<?php

namespace App\Providers;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider
{
    public function register(): void
    {
      /*  $client=ClientBuilder::create()
            ->setHosts([('localhost:9200')])
            ->setLogger(app('log'))
            ->build();


           /*->setRetries(1)
            ->setHosts([env('ELASTICSEARCH_HOST')])
            ->setLogger(app('log'))
            ->build();
*/
     $this->app->singleton(Client::class, function (Application $app) {
            $config = $app->make('config')->get('elasticsearch');
            return ClientBuilder::create()
                ->setHosts($config['hosts'])
                ->setRetries($config['retries'])
                ->build();
        });
    }
}
