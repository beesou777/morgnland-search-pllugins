<?php

namespace MorgenlandSearch\Controllers;

use MorgenlandSearch\Services\HttpClientService;
use Plenty\Modules\Webshop\Contracts\LocalizationRepositoryContract;
use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;
use Plenty\Plugin\Http\Response;

class FaqController extends Controller
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
            /**
             * FILTER
             */
            $filter = [
                'lang' => $lang,
            ];
            
            
            $host = null;
            if ($request->hasHeader("host")){
                $host = $request->header("host");
                $filter['host'] = $host;
            }

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

            $result = $this->clientService->get(
                '/api/morgenland-faqs',
                $filter
            );
        } catch (\Exception $exception) {
            $response->json([
                'message' => 'Failed to load results!',
                'exception' => $exception->getMessage()
            ], 400);
        }
        return $response->json($result);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categories(Request $request, Response $response): \Symfony\Component\HttpFoundation\Response
    {
        try {
            $lang = $this->localizationRepositoryContract->getLanguage();
            /**
             * FILTER
             */
            $filter = [
                'lang' => $lang,
            ];

            /**
             * SEARCH
             */
            $search = $request->get('search');
            if ($search) {
                $filter['search'] = $search;
            }

            $result = $this->clientService->get(
                '/api/morgenland-faqs-categories',
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
