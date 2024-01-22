<?php

namespace MorgenlandSearch\Contexts;

use Ceres\Contexts\ItemSearchContext;
use IO\Helper\ContextInterface;
use MorgenlandSearch\Services\PropertiesService;

class MorganlandSearchContext extends ItemSearchContext implements ContextInterface
{
    /**
     * @param $params
     * @return void
     */
    public function init($params): void
    {

        parent::init($params);

        /**
         * @var PropertiesService $propertyService
         */
        $propertyService = pluginApp(PropertiesService::class);
        $filter_facets = $propertyService->index();
        $this->facets = $filter_facets['data'] ?? [];
    }
}