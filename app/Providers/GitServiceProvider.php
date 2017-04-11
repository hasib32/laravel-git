<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\GitProviders\Contracts\GitProviderInterface;
use App\GitProviders\GithubProvider;

class GitServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(GitProviderInterface::class, function ($app) {
            $config = config('services.github');
            return new GithubProvider($config['client_id'], $config['client_secret'], $config['redirect']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [GitProviderInterface::class];
    }
}
