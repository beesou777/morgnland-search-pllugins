<?php

namespace MorgenlandSearch\Controllers;

use MorgenlandSearch\Services\HttpClientService;
use Plenty\Modules\Webshop\Contracts\LocalizationRepositoryContract;
use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;
use Plenty\Plugin\Http\Response;
use Plenty\Plugin\Templates\Twig;

class BlogController extends Controller
{

    public function __construct(
        protected HttpClientService              $clientService,
        protected LocalizationRepositoryContract $localizationRepositoryContract
    )
    {
        parent::__construct();
    }

    public function blogCategories(Request $request, Response $response): \Symfony\Component\HttpFoundation\Response
    {
        try {
            $lang = $this->localizationRepositoryContract->getLanguage();
            /**
             * FILTER
             */
            $filter = [
                'lang' => $lang,
            ];

            $result = $this->clientService->get(
                '/api/morgenland-blog-categories',
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

    public function blogs(Request $request, Response $response): \Symfony\Component\HttpFoundation\Response
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
             * CATEGORY
             */
            $category = $request->get('category');
            if ($category) {
                $filter['category'] = $category;
            }

            /**
             * CATEGORY
             */
            $page = $request->get('page');
            if ($page) {
                $filter['page'] = $page;
            }

            /**
             * Search
             */
            $search = $request->get('search');
            if ($search) {
                $filter['search'] = $search;
            }

            /**
             * PER PAGE
             */
            $per_page = $request->get('per_page');
            if ($per_page) {
                $filter['per_page'] = $per_page;
            }


            /**
             * CATEGORY
             */
            $item_category = $request->get('item_category');
            if ($item_category) {
                $filter['item_category'] = $item_category;
            }



            $result = $this->clientService->get(
              '/api/morgenland-blogs',
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


    public function blogDetail(string $category_slug, string $slug,Request $request, Response $response): \Symfony\Component\HttpFoundation\Response
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
            }
            if ($host){
                $filter['host'] = $host;
            }

            $result = $this->clientService->get(sprintf('/api/morgenland-blogs/%s/%s', $category_slug, $slug), $filter);
        } catch (\Exception $exception) {
            $response->json([
                'message' => 'Failed to load results!',
                'exception' => $exception->getMessage()
            ], 400);
        }
        return $response->json($result);
    }


    public function blogDetailSSR(string $category_slug, string $slug, Twig $twig, Request $request, int $iteration = 1)
    {
        try {

            $host = null;
            if ($request->hasHeader("host")){
                $host = $request->header("host");
            }
            $blogDetail = $this->clientService->get(sprintf('/api/morgenland-blogs/%s/%s', $category_slug, $slug,), [
                'host' => $host,
            ]);
        } catch (\Exception $exception) {
            if ($iteration <= 1) {
                return $this->blogDetailSSR($category_slug, $slug, $twig, $request, $iteration + 1);
            } else {
                return $twig->render('mlt::StaticPages.PageNotFound');
            }
        }
        return $twig->render('MorgenlandSearch::Blog.BlogDetail', ['data' => $blogDetail['data'] ?? null]);
    }

}
