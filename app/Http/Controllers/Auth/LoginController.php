<?php

namespace App\Http\Controllers\Auth;

use App\GitProviders\Contracts\GitProviderInterface;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

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
     * Redirect the user to the GitHub authentication page.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function redirectToProvider(Request $request)
    {
        return $this->gitProvider->redirect();
    }

    public function handleProviderCallback()
    {
        $user = $this->gitProvider->getUser();
    }

    public function getIssues()
    {
        $issues = $this->gitProvider->getIssues();
    }

    public function getRepositories()
    {
        $repositories = $this->gitProvider->getRepositories();
    }
}
