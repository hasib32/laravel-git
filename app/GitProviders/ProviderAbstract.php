<?php

namespace App\GitProviders;

use App\GitProviders\Contracts\GitProviderInterface;
use GuzzleHttp\Client;

abstract class ProviderAbstract implements GitProviderInterface
{
    /**
     * The client ID.
     *
     * @var string
     */
    protected $clientId;

    /**
     * The client secret.
     *
     * @var string
     */
    protected $clientSecret;

    /**
     * The redirect URL.
     *
     * @var string
     */
    protected $redirectUrl;

    /**
     * http client instance
     *
     * @var Client
     */
    protected $httpClient;

    /**
     * Create a new provider instance.
     *
     * @param $clientId
     * @param $clientSecret
     * @param $redirectUrl
     */
    public function __construct($clientId, $clientSecret, $redirectUrl)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUrl = $redirectUrl;

        $this->httpClient = new Client();
    }

    /**
     * Get the auth url
     *
     * @return string
     */
    abstract function getAuthUrl();

    /**
     * Get the access_token url
     *
     * @return string
     */
    abstract function getAccessTokenUrl();

    /**
     * POST request to the provider
     *
     * @param $url
     * @param array $params
     * @return array
     */
    protected function postDataToProvider($url, array $params)
    {
        $response = $this->httpClient->post($url, [
            'headers' => ['Accept' => 'application/json'],
            'form_params'   => $params
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * GET request to the provider
     *
     * @param $url
     * @param $headers
     * @return array
     */
    public function getDataFromProvider($url, $headers)
    {
        $response = $this->httpClient->get($url, $headers);

        return json_decode($response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    public function redirect()
    {
        return redirect($this->getAuthUrl());
    }

    /**
     * Build URL
     *
     * @param $url
     * @param array $params
     * @return string
     */
    protected function buildAuthUrl($url, array $params)
    {
        return $url.'?'.http_build_query($params);
    }
}