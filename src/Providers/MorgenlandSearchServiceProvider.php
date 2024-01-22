<?php

namespace MorgenlandSearch\Providers;

use MorgenlandSearch\Middleware\Middleware;
use MorgenlandSearch\Services\SearchService;
use MorgenlandSearch\Services\VariantFilterService;
use Plenty\Plugin\ServiceProvider;

/**
 * Class MorgenlandSearchServiceProvider
 * @package MorgenlandSearch\Providers
 */
class MorgenlandSearchServiceProvider extends ServiceProvider
{
    /**
    * Register the route service provider
    */
    public function register()
    {
        $this->getApplication()->register(MorgenlandSearchsRouteServiceProvider::class);
        $this->getApplication()->singleton(SearchService::class);
        $this->getApplication()->singleton(VariantFilterService::class);
        $this->addGlobalMiddleware(Middleware::class);
    }
}