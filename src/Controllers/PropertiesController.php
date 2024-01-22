<?php

namespace MorgenlandSearch\Controllers;

use MorgenlandSearch\Services\HttpClientService;
use MorgenlandSearch\Services\PropertiesService;
use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;
use Plenty\Plugin\Http\Response;

class PropertiesController extends Controller
{
    public function __construct(
        protected PropertiesService $propertiesService,
        protected HttpClientService $clientService
    )
    {
        parent::__construct();
    }


    /**
     * @param Request $request
     * @param Response $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, Response $response): \Symfony\Component\HttpFoundation\Response
    {
        try {
            $host = null;
            if ($request->hasHeader("host")){
                $host = $request->header("host");
            }
            $result = $this->parseResult($this->clientService->get('/api/morgenland-variant-search', 
                [
                    "host" => $host,
                ]
            ));
        } catch (\Exception $exception) {
            $response->json([
                'message' => 'Failed to load results!',
                'exception' => $exception->getMessage()
            ], 400);
        }
        return $response->json($result);
    }

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
}
