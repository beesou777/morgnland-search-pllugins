<?php

use GuzzleHttp\Client;

/**
 * GUZZLE CLIENT INSTANCE
 */
$client = new Client([
    'base_uri' => SdkRestApi::getParam('base_url')
]);

/**
 * RESPONSE BODY
 */
$response = $client->get(SdkRestApi::getParam('url'), [
    'query' => SdkRestApi::getParam('params') ?: []
]);


return json_decode($response->getBody());