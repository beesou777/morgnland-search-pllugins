<?php

namespace MorgenlandSearch\Controllers;


use MorgenlandSearch\Services\HttpClientService;
use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;
use Plenty\Plugin\Http\Response;

class CategoryController extends Controller
{
    public function __construct(
        protected HttpClientService $clientService
    )
    {
        parent::__construct();
    }

    public function getLinks(Request $request, Response $response): \Symfony\Component\HttpFoundation\Response
    {
        try {

            $host = null;
            if ($request->hasHeader("host")){
                $host = $request->header("host");
            }
            $result = $this->clientService->get(
                '/api/morgenland-category-links',
                [
                    'category_id' => $request->get('category_id'),
                    'host' => $host,
                ]
            );
        } catch (\Exception $exception) {
            $response->json([
                'message' => 'Failed to load results!',
                'exception' => $exception->getMessage()
            ], 400);
        }

        return $response->json($result);
    }


    public function categoryGroups(Request $request, Response $response): \Symfony\Component\HttpFoundation\Response
    {
        try {
            $result = $this->clientService->get(
                '/api/morgenland-category-groups'
            );
        } catch (\Exception $exception) {
            $response->json([
                'message' => 'Failed to load results!',
                'exception' => $exception->getMessage()
            ], 400);
        }
        return $response->json($result);
    }
}
