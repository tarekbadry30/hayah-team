<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\DonationHelp;
use App\Models\DonationType;
use App\Models\Food;
use App\Models\MobileSlider;
use App\Models\Portfolio;
use App\Models\WebsiteSlider;
use App\Observers\CategoryObserver;
use App\Observers\DonationHelpObserver;
use App\Observers\DonationTypeObserver;
use App\Observers\FoodObserver;
use App\Observers\MobileSliderObserver;
use App\Observers\PortfolioObserver;
use App\Observers\WebsiteSliderObserver;
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
        Food::observe(FoodObserver::class);
        DonationHelp::observe(DonationHelpObserver::class);
        WebsiteSlider::observe(WebsiteSliderObserver::class);
        MobileSlider::observe(MobileSliderObserver::class);
        Portfolio::observe(PortfolioObserver::class);
    }
}
