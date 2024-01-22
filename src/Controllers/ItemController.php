<?php

namespace MorgenlandSearch\Controllers;

use MorgenlandSearch\Services\HttpClientService;
use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;
use Plenty\Plugin\Http\Response;

class ItemController extends Controller
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
            $item_id = $request->get('item_id');
            $variant_id = $request->get('variant_id');


            $host = null;
            if ($request->hasHeader("host")){
                $host = $request->header("host");
            }

            $data = [];

            if ($host) {
                $data['host'] = $host;
            }

            if ($item_id) {
                $data['item_id'] = $item_id;
            }

            if ($variant_id) {
                $data['variant_id'] = $variant_id;
            }
            $result = $this->clientService->get(
                '/api/morgenland-item-links',
                $data
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
