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
            'state'         => $this->state,
            'scope'         => 'user repo'
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
    protected function getAccessToken()
    {
        // return from session if find
        if (request()->session()->has(self::GITHUB_SESSION_KEY)) {
            $accessToken = request()->session()->get(self::GITHUB_SESSION_KEY);

            return $accessToken;
        }

        $code = request()->input('code');

        $accessToken = $this->postDataToProvider($this->getAccessTokenUrl(), [
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code'          => $code,
            'redirect_uri'  => $this->redirectUrl
        ]);

        if (isset($accessToken['access_token'])) {
            // store access_token in session
            request()->session()->put(self::GITHUB_SESSION_KEY, $accessToken['access_token']);
        }

        return $accessToken['access_token'];
    }

    /**
     * {@inheritdoc}
     */
    public function getUser()
    {
        $accessToken = $this->getAccessToken();

        $userUrl = 'https://api.github.com/user?access_token='.$accessToken;

        $user = $this->getDataFromProvider($userUrl, $this->getHeaders());

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getIssues()
    {
        $accessToken = $this->getAccessToken();

        $issueUrl = 'https://api.github.com/user/issues?access_token='.$accessToken;
        $issues = $this->getDataFromProvider($issueUrl, [
            'headers'   => [
                'Accept'    => 'application/vnd.github.v3.raw+json'
            ]
        ]);

        return $issues;
    }

    /**
     * {@inheritdoc}
     */
    public function getRepositories()
    {
        $accessToken = $this->getAccessToken();

        $repoUrl = 'https://api.github.com/user/repos?access_token='.$accessToken;
        $repositories = $this->getDataFromProvider($repoUrl, $this->getHeaders());

        return $repositories;
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
            ]
        ];
    }
}