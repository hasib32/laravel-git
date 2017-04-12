<?php

namespace App\Http\Controllers;

use App\GitProviders\Contracts\GitProviderInterface;

class GitController extends Controller
{
    /**
     * Instance of GitProviderInterface
     *
     * @var GitProviderInterface
     */
    protected $gitProvider;

    /**
     * Create a new controller instance.
     *
     * @param GitProviderInterface $gitProvider
     *
     */
    public function __construct(GitProviderInterface $gitProvider)
    {
        $this->gitProvider = $gitProvider;
    }

    /**
     * Display all issues
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIssues()
    {
        $issues = $this->gitProvider->getIssues();

        return view('issue', ['issues'  => $issues]);
    }

    /**
     * Display all Repositories
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getRepositories()
    {
        $repositories = $this->gitProvider->getRepositories();

        return view('repo', ['repos'    => $repositories]);
    }
}
