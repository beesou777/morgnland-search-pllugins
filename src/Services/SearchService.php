<?php

namespace MorgenlandSearch\Services;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use MorgenlandSearch\Constants\AppConfig;
use Plenty\Modules\Webshop\Contracts\LocalizationRepositoryContract;
use Plenty\Plugin\Http\Request;

class SearchService
{
    public function __construct(
        protected HttpClientService              $clientService,
        protected LocalizationRepositoryContract $localizationRepositoryContract
    )
    {
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws Exception|GuzzleException
     */
    public function search(Request $request): mixed
    {
        $host = null;
        if ($request->hasHeader("host")){
            $host = $request->header("host");
        }
        $lang = $this->localizationRepositoryContract->getLanguage();
        $searchTerm = $request->get(AppConfig::SEARCH_KEY);
        $per_page = $request->get(AppConfig::PER_PAGE_KEY);
        return $this->clientService->get(
            '/api/morgenland-search',
            [
                'host' => $host,
                'lang' => $lang,
                'query' => $searchTerm,
                'per_page' => $per_page
            ]
        );
    }
}
