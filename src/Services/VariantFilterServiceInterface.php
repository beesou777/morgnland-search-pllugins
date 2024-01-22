<?php

namespace MorgenlandSearch\Services;

use Ceres\Helper\ExternalSearch;
use Plenty\Plugin\Http\Request;

/**
 * Interface SearchServiceInterface
 * @package Findologic\Services
 */
interface VariantFilterServiceInterface
{
    /**
     * @param Request $request
     * @param ExternalSearch $externalSearch
     */
    public function handleFilter(Request $request, ExternalSearch $externalSearch);
}