<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        if($this->app->environment() == 'production') {
            \URL::forceScheme('https');
            \URL::forceRootUrl(\Config::get('app.url'));
        }
        Blade::directive('money', function ($money) {
            return "₦ <?php echo number_format($money, 2); ?>";
        });
    }
}
