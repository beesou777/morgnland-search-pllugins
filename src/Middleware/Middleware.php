<?php

namespace MorgenlandSearch\Middleware;

use Ceres\Helper\ExternalSearch;
use IO\Helper\TemplateContainer;
use MorgenlandSearch\Contexts\MorganlandSearchContext;
use MorgenlandSearch\Contexts\MorgenlandCategoryContext;
use MorgenlandSearch\Services\VariantFilterService;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\Http\Request;
use Plenty\Plugin\Http\Response;
use Plenty\Plugin\Log\Loggable;
use Plenty\Plugin\Middleware as PlentyMiddleware;

class Middleware extends PlentyMiddleware
{
    use Loggable;

    /**
     * @param Dispatcher $eventDispatcher
     * @param VariantFilterService $variantFilterService
     */
    public function __construct(
        private Dispatcher           $eventDispatcher,
        private VariantFilterService $variantFilterService
    )
    {
    }

    /**
     * @param Request $request
     * @return void
     */
    public function before(Request $request)
    {
        /**
         * OVERRIDING CATEGORY PAGE FACETS DATA
         */
        $this->eventDispatcher->listen(
            'IO.ctx.category.item',
            function (TemplateContainer $templateContainer) {
                $templateContainer->setContext(MorgenlandCategoryContext::class);
                return false;
            }
        );

        /**
         * OVERRIDING SEARCH PAGE FACETS DATA
         */
        $this->eventDispatcher->listen(
            'IO.ctx.search',
            function (TemplateContainer $templateContainer) {
                $templateContainer->setContext(MorganlandSearchContext::class);
                return false;
            }
        );

        /**
         * OVERRIDING FILTERING PROPERTY
         */
        $this->eventDispatcher->listen(
            'Ceres.Search.Query',
            function (ExternalSearch $externalSearch) use ($request) {
                $this->variantFilterService->handleFilter($request, $externalSearch);
            }
        );
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function after(Request $request, Response $response): Response
    {
        return $response;
    }
}