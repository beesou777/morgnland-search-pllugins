<?php

namespace MorgenlandSearch\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use MorgenlandSearch\Services\SearchService;
use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;
use Plenty\Plugin\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class MorgenlandSearchController extends Controller
{

    public function __construct(
        protected SearchService $searchService,
    )
    {
        parent::__construct();
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return SymfonyResponse
     * @throws GuzzleException
     */
    public function search(Request $request, Response $response): SymfonyResponse
    {
        try {
            $result = $this->searchService->search($request);
        } catch (\Exception $exception) {
            $response->json([
                'message' => 'Failed to load results!',
                'exception' => $exception->getMessage()
            ], 400);
        }

        $result = $result + [
            "host"=> $request->header("host")
            ];

        return $response->json($result);
    }
}