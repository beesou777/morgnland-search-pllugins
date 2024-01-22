<?php

namespace MorgenlandSearch\Services;


use MorgenlandSearch\Constants\AppConfig;
use Plenty\Modules\Plugin\Libs\Contracts\LibraryCallContract;

class HttpClientService
{

    /**
     * CONSTRUCTION FUNCTION
     */
    public function __construct(protected LibraryCallContract $libCall)
    {
    }

    /**
     * @param string $url
     * @param array $params
     * @return array
     */
    public function get(string $url, array $params = [])
    {
        return $this->libCall->call('MorgenlandSearch::guzzle_connector', [
            'base_url' => AppConfig::SEARCH_API_URL,
            'url' => $url,
            'params' => $params
        ]);
    }
}