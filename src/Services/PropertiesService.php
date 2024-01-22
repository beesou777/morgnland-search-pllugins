<?php

namespace MorgenlandSearch\Services;

use IO\Extensions\Constants\ShopUrls;
use IO\Services\CategoryService;
use Plenty\Plugin\Http\Request;
use Plenty\Modules\Webshop\Contracts\LocalizationRepositoryContract;

class PropertiesService
{
    public function __construct(
        protected HttpClientService              $clientService,
        protected LocalizationRepositoryContract $localizationRepositoryContract,
        protected ShopUrls                       $shopUrls
    )
    {
    }

    /**
     * @return array
     */
    public function index(): array
    {
        $lang = $this->localizationRepositoryContract->getLanguage();
        $searchPage = $this->shopUrls->is('search');

        /**
         * PROPERTY PARAMS
         */
        $params = [
            'lang' => $lang,
        ];

        if (isset($_SERVER['HTTP_HOST'])) {
            $host = $_SERVER['HTTP_HOST'];
            $params['host'] = $host;
        }

        /**
         * @var CategoryService $categoryService
         */
        $categoryService = pluginApp(CategoryService::class);
        $currentCategory = $categoryService->getCurrentCategory();

        if (!$searchPage && $currentCategory) {
            $params['category'] = $currentCategory['id'] ?? null;
        }

        return $this->clientService->get('/api/morgenland-properties', $params);
    }

}
