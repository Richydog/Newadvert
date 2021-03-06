<?php

namespace App\Console\Commands\Search;

use App\Advert;
use App\Model\Banner\Banner;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Illuminate\Console\Command;
use Elasticsearch\Client;
use App\Model\Adverts\Advert\Value;
class InitCommand extends Command
{
    protected $signature = 'search:init';

    private $client;

    public function __construct(Client $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    public function handle(): bool
    {
        $this->initAdverts();
        $this->initBanners();

        return true;
    }

    private function initAdverts(): void
    {
        try {
            $this->client->indices()->delete([
                'index' => 'adverts'
            ]);
        } catch (Missing404Exception $e) {
        }

        $this->client->indices()->create([
            'index' => 'adverts',
                      'body' => [
                'mappings' => [
                  // 'advert' => [
                        '_source' => [
                            'enabled' => true,
                        ],
                        'properties' => [
                            'id' => [
                                'type' => 'integer',
                            ],
                            'published_at' => [
                                'type' => 'date',
                            ],
                            'title' => [
                                'type' => 'text',
                            ],
                            'content' => [
                                'type' => 'text',
                            ],
                            'price' => [
                                'type' => 'integer',
                            ],
                            'status' => [
                                'type' => 'keyword',
                            ],
                            'categories' => [
                                'type' => 'integer',
                            ],
                            'regions' => [
                                'type' => 'integer',
                            ],
                            'values' => [
                                'type' => 'nested',
                                'properties' => [
                                    'attribute' => [
                                        'type' => 'integer'
                                    ],
                                    'value_string' => [
                                        'type' => 'keyword',
                                    ],
                                    'value_int' => [
                                        'type' => 'integer',
                                    ],
                                ],
                            ],
                        ],

          ],


          'settings' => [
                    'analysis' => [
                        'char_filter' => [
                            'replace' => [
                                'type' => 'mapping',
                                'mappings' => [
                                    '&=> and '
                                ],
                            ],
                        ],
                     'filter' => [
                            'word_delimiter' => [
                                'type' => 'word_delimiter',
                                'split_on_numerics' => false,
                                'split_on_case_change' => true,
                                'generate_word_parts' => true,
                                'generate_number_parts' => true,
                                'catenate_all' => true,
                                'preserve_original' => true,
                                'catenate_numbers' => true,
                            ],
                            'trigrams' => [
                                'type' => 'ngram',
                                'min_gram' => 3,
                                'max_gram' => 3,
                            ],
                        ],
                        'analyzer' => [
                            'default' => [
                                'type' => 'custom',
                                'char_filter' => [
                                    'html_strip',
                                    'replace',
                                ],
                                'tokenizer' => 'whitespace',
                                'filter' => [
                                    'lowercase',
                                    'word_delimiter',
                                    'trigrams',
                                ],
                            ],
                        ],
                  ],
            ],

        ],

        ]);

        foreach (Advert::active()->orderBy('id')->cursor() as $advert) {
            $regions = [];
            if ($region = $advert->region) {
                do {
                    $regions[] = $region->id;
                } while ($region = $region->parent);
            }
            $this->client->index([
                'index' => 'adverts',
               // 'type' => 'advert',
                'id' => $advert->id,
                'body' => [
                    'id' => $advert->id,
                    'published_at' => $advert->published_at ? $advert->published_at->format(DATE_ATOM) : null,
                    'title' => $advert->title,
                    'content' => $advert->content,
                    'price' => $advert->price,
                    'status' => $advert->status,
                    'categories' => array_merge(
                        [$advert->category->id],
                        $advert->category->ancestors()->pluck('id')->toArray()
                    ),
                    'regions' => $regions ?: [0],
                    'values' => array_map(function (Value $value) {
                        return [
                            'attribute' => $value->attribute_id,
                            'value_string' => (string)$value->value,
                            'value_int' => (int)$value->value,
                        ];
                    }, $advert->values()->getModels()),
                ],
            ]);

        }


    }
    private function initBanners(): void
    {
        try {
            $this->client->indices()->delete([
                'index' => 'banners'
            ]);
        } catch (Missing404Exception $e) {
        }

        $this->client->indices()->create([
            'index' => 'banners',
            'body' => [
                'mappings' => [
                   // 'banners' => [
                        '_source' => [
                            'enabled' => true,
                        ],
                        'properties' => [
                            'id' => [
                                'type' => 'integer',
                            ],
                            'status' => [
                                'type' => 'keyword',
                            ],
                            'format' => [
                                'type' => 'keyword',
                            ],
                            'categories' => [
                                'type' => 'integer',
                            ],
                            'regions' => [
                                'type' => 'integer',
                            ],
                        ],
                    ],
                ],
         //   ],
        ]);
    }

}
