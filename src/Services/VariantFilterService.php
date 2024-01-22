<?php

namespace MorgenlandSearch\Services;

use Ceres\Helper\ExternalSearch;
use Exception;
use IO\Extensions\Constants\ShopUrls;
use IO\Services\CategoryService;
use Plenty\Modules\Webshop\Contracts\LocalizationRepositoryContract;
use Plenty\Plugin\Http\Request;

class VariantFilterService implements VariantFilterServiceInterface
{

    public function __construct(
        protected HttpClientService $clientService,
        protected ShopUrls          $shopUrls
    )
    {
    }

    /**
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function filter(Request $request): array
    {
        $host = null;
        if ($request->hasHeader("host")){
            $host = $request->header("host");
        }
        $page = $request->get('page');
        $current_page = $page && is_numeric($page) ? $page : 1;
        $hasSelectedFilters = $request->get('attrib') !== null;
        $searchQuery = $request->get('query') ?: null;
        $sorting = $request->get('sorting');
        $isSearchPage = $this->shopUrls->is('search');

        /**
         * @var LocalizationRepositoryContract $localizationRepositoryContract
         */
        $localizationRepositoryContract = pluginApp(LocalizationRepositoryContract::class);
        $lang = $localizationRepositoryContract->getLanguage();
        $items = $request->get('items');
        $per_page = $items && is_numeric($items) ? $items : 30;

        /**
         * REQUEST QUERY PARAMS
         */
        $params = [
            'lang' => $lang,
            'page' => $current_page,
            'per_page' => $per_page,
            'host' => $host,
        ];

        /**
         * @var CategoryService $categoryService
         */
        $categoryService = pluginApp(CategoryService::class);
        $currentCategory = $categoryService->getCurrentCategory();

        if (!$isSearchPage && $currentCategory) {
            $params['category'] = $currentCategory['id'] ?? null;
        } else if ($searchQuery) {
            $params['is_search_page'] = true;
            $params['query'] = $searchQuery;
        }

        $category = $request->get('category');
        if ($category) {
            $params['category'] = $category;
        }

        if ($hasSelectedFilters) {
            $params['attrib'] = $request->get('attrib');
        }

        if ($sorting) {
            $params['sorting'] = $sorting;
        }


        return $this->parseResult($this->clientService->get('/api/morgenland-variant-search', $params));
    }


    /**
     * @param array $result
     * @return array<string,mixed>
     */
    public function parseResult(array $result): array
    {
        $parsed = [
            'variant_ids' => [],
        ];

        $result_data = $result['data'] ?? [];

        /**
         * VARIANT IDS
         */
        foreach ($result_data as $data) {
            if (isset($data['id'])) {
                $parsed['variant_ids'][] = $data['id'];
            }
        }

        $parsed['total'] = $result['meta']['total'] ?? 0;


        return $parsed;
    }


    /**
     * @param Request $request
     * @param ExternalSearch $externalSearch
     * @throws Exception
     */
    public function handleFilter(Request $request, ExternalSearch $externalSearch): void
    {
        $hasSelectedFilters = $request->get('attrib') !== null || $request->get('query') !== null || $request->get('category') !== null;
        if ($hasSelectedFilters) {
            $result = $this->filter($request);
            $totalData = $result['total'] ?? 0;
            $variation_ids = $result['variant_ids'] ?? [];
            if ($totalData > 0) {
                $externalSearch->setResults($variation_ids, $totalData);
            } else {
                $externalSearch->setResults([]);
            }
        }
    }
}
