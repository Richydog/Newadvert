<?php

namespace App\UseCases\Adverts;

use App\Advert;
use App\Model\Adverts\Category;
use App\Model\Region;
use App\Http\Requests\Adverts\SearchRequest;
use Elasticsearch\Client;
use Illuminate\Database\Query\Expression;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Response;
class SearchService
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param Category|null $category
     * @param Region|null $region
     * @param SearchRequest $request
     * @param int $perPage
     * @param int $page
     * @return SearchResult
     */
    public function search(?Category $category, ?Region $region, SearchRequest $request, int $perPage, int $page): SearchResult
    {
        $values = array_filter((array)$request->input('attrs'), function ($value) {
            return !empty($value['equals']) || !empty($value['from']) || !empty($value['to']);
        });

        $response = $this->client->search([
            'index' => 'adverts',
          'type' => '_doc',
            'body' => [
                '_source' => ['id'],
               'from' =>($page-1)*$perPage,
                'size' => $perPage,
                'sort' => empty($request['text']) ? [
                    ['published_at' => ['order' => 'desc']],
                ] : [],
                'aggs' => [
                    'group_by_region' => [
                        'terms' => [
                            'field' => 'regions',
                        ],
                    ],
                    'group_by_category' => [
                        'terms' => [
                            'field' => 'categories',
                        ],
                    ],
                ],
                'query' => [
                    'bool' => [
                        'must' => array_merge(
                            [
                                ['term' => ['status' => Advert::STATUS_ACTIVE]],
                            ],
                            array_filter([
                                $category ? ['term' => ['categories' => $category->id]] : false,
                                $region ? ['term' => ['regions' => $region->id]] : false,
                                !empty($request['text']) ? ['multi_match' => [
                                    'query' => $request['text'],
                                    'fields' => [ 'title^3', 'content' ]
                                ]] : false,
                            ]),
                            array_map(function ($value, $id) {
                                return [
                                    'nested' => [
                                        'path' => 'values',
                                        'query' => [
                                            'bool' => [
                                                'must' => array_values(array_filter([
                                                    ['match' => ['values.attribute' => $id]],
                                                    !empty($value['equals']) ? ['match' => ['values.value_string' => $value['equals']]] : false,
                                                    !empty($value['from']) ? ['range' => ['values.value_int' => ['gte' => $value['from']]]] : false,
                                                    !empty($value['to']) ? ['range' => ['values.value_int' => ['lte' => $value['to']]]] : false,
                                                ])),
                                            ],
                                        ],
                                    ],
                                ];
                            }, $values, array_keys($values))
                        )
                    ],
                ],
            ],
        ]);


        $ids = array_column($response['hits']['hits'], '_id');

       if ($ids) {
            $items = Advert::active()
                ->with(['category', 'region'])
                ->whereIn('id', $ids)
                ->orderBy(new Expression('FIELD(id,' . implode(',', $ids) . ')'))
                ->get();
            $pagination = new LengthAwarePaginator($items,current($response['hits']['total']), $perPage,$page);
        } else {
            $pagination = new LengthAwarePaginator([], 0, $perPage,$page);
        }

        return new SearchResult(
            $pagination,
            array_column($response['aggregations']['group_by_region']['buckets'], 'doc_count', 'key'),
            array_column($response['aggregations']['group_by_category']['buckets'], 'doc_count', 'key')
        );
    }
}
