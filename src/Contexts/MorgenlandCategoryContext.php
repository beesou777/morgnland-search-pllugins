<?php

namespace MorgenlandSearch\Contexts;

use Ceres\Contexts\CategoryItemContext;
use IO\Helper\ContextInterface;
use MorgenlandSearch\Services\PropertiesService;

class MorgenlandCategoryContext extends CategoryItemContext implements ContextInterface
{

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

