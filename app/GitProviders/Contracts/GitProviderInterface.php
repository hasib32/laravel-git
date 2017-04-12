<?php

namespace App\GitProviders\Contracts;

interface GitProviderInterface
{
    /**
     * Redirect user to provider login site
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function redirect();

    /**
     * Get the authenticated user
     *
     * @return array
     */
    public function getUser();

    /**
     * Get all the issues for the user
     *
     * @return array
     */
    public function getIssues();

    /**
     * Get all the repositories for the user
     *
     * @return array
     */
    public function getRepositories();
}