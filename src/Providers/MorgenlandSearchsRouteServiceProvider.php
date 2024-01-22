<?php

namespace MorgenlandSearch\Providers;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\Router;

/**
 * Class MorgenlandSearchRouteServiceProvider
 * @package MorgenlandSearch\Providers
 */
class MorgenlandSearchsRouteServiceProvider extends RouteServiceProvider
{
    /**
     * @param Router $router
     */
    public function map(Router $router)
    {
        $router->get('rest/morgenland-item-search', 'MorgenlandSearch\Controllers\MorgenlandSearchController@search');
        $router->get('rest/morgenland-item-links', 'MorgenlandSearch\Controllers\ItemController@getLinks');
        $router->get('rest/morgenland-category-links', 'MorgenlandSearch\Controllers\CategoryController@getLinks');
        $router->get('rest/morgenland-faqs', 'MorgenlandSearch\Controllers\FaqController@index');
        $router->get('rest/morgenland-faq-categories', 'MorgenlandSearch\Controllers\FaqController@categories');
        $router->get('rest/morgenland-look-books', 'MorgenlandSearch\Controllers\LookBookController@index');
        $router->get('rest/morgenland-category-groups', 'MorgenlandSearch\Controllers\CategoryController@categoryGroups');
        $router->get('rest/morgenland-blog-categories', 'MorgenlandSearch\Controllers\BlogController@blogCategories');
        $router->get('rest/morgenland-blogs', 'MorgenlandSearch\Controllers\BlogController@blogs');
        $router->get('rest/morgenland-blogs/{category_slug}/{slug}', 'MorgenlandSearch\Controllers\BlogController@blogDetail');
        $router->get('blog/{category_slug}/{slug}', 'MorgenlandSearch\Controllers\BlogController@blogDetailSSR');
    }
}
