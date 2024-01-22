<?php

namespace MorgenlandSearch\Controllers;

use MorgenlandSearch\Services\HttpClientService;
use Plenty\Modules\Webshop\Contracts\LocalizationRepositoryContract;
use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;
use Plenty\Plugin\Http\Response;

class LookBookController extends Controller
{
    public function __construct(
        protected HttpClientService              $clientService,
        protected LocalizationRepositoryContract $localizationRepositoryContract
    )
    {
        parent::__construct();
    }

    public function index(Request $request, Response $response): \Symfony\Component\HttpFoundation\Response
    {
        try {
            $lang = $this->localizationRepositoryContract->getLanguage();
            $host = null;
            if ($request->hasHeader("host")){
                $host = $request->header("host");
            }

            /**
             * FILTER
             */
            $filter = [
                'lang' => $lang,
                'host' => $host,
            ];

            /**
             * SEARCH
             */
            $search = $request->get('search');
            if ($search) {
                $filter['search'] = $search;
            }

            /**
             * CATEGORY
             */
            $category = $request->get('category');
            if ($category) {
                $filter['category'] = $category;
            }

            /**
             * CATEGORY
             */
            $group = $request->get('group');
            if ($group) {
                $filter['group'] = $group;
            }

            $result = $this->clientService->get(
                '/api/morgenland-look-books',
                $filter
            );;
        } catch (\Exception $exception) {
            $response->json([
                'message' => 'Failed to load results!',
                'exception' => $exception->getMessage()
            ], 400);
        }
        return $response->json($result);
    }

}
