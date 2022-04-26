<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\DonationType;
use App\Observers\CategoryObserver;
use App\Observers\DonationTypeObserver;
use Illuminate\Support\ServiceProvider;

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
        DonationType::observe(DonationTypeObserver::class);
        Category::observe(CategoryObserver::class);
    }
}
