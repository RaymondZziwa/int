<?php


namespace App\Providers;

use App\Console\Commands\SendPostsToSubscribers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Application;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        $this->app->booted(function () {
            $application = $this->app->make(Application::class);
            $application->add(new SendPostsToSubscribers);
        });
    }
}
