<?php

namespace App\GitProviders;

class GithubProvider extends ProviderAbstract
{
    const GITHUB_SESSION_KEY = 'github_access_token';

    private $state = 'pBWk4KYOWbt3z8r7EHVqQaQlr9cKRv1oR1E9KyFQZLY';

    /**
     * {@inheritdoc}
     */
    public function getAuthUrl()
    {
        $params = [
            'client_id'     => $this->clientId,
            'redirect_uri'  => $this->redirectUrl,
            'state'         => $this->state
        ];

        return $this->buildAuthUrl('https://github.com/login/oauth/authorize', $params);
    }

    /**
     * {@inheritdoc}
     */
    public function getAccessTokenUrl()
    {
        return 'https://github.com/login/oauth/access_token';
    }

    /**
     * Get access_token from callback response
     *
     * @return array
     */
    protected function getAccessTokenFromResponse()
    {
        $code = request()->input('code');

        $accessToken = $this->postDataToProvider($this->getAccessTokenUrl(), [
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code'          => $code,
            'redirect_uri'  => $this->redirectUrl
        ]);

        return $accessToken;
    }

    /**
     * {@inheritdoc}
     */
    public function getUser()
    {
        $accessToken = $this->getAccessTokenFromResponse()['access_token'];

        $userUrl = 'https://api.github.com/user?access_token='.$accessToken;

        $user = $this->getDataFromProvider($userUrl, $this->getHeaders());

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getIssues()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function getRepositories()
    {

    }

    /**
     * Get the default options for an HTTP request.
     *
     * @return array
     */
    protected function getHeaders()
    {
        return [
            'headers' => [
                'Accept' => 'application/vnd.github.v3+json',
            ],
        ];
    }
}