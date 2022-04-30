<?php

namespace App\Observers;

use App\Models\WebsiteSlider;
use Illuminate\Support\Facades\File;

class WebsiteSliderObserver
{
    /**
     * Handle the WebsiteSlider "created" event.
     *
     * @param  \App\Models\WebsiteSlider  $websiteSlider
     * @return void
     */
    public function created(WebsiteSlider $websiteSlider)
    {
        //
    }

    /**
     * Handle the WebsiteSlider "updated" event.
     *
     * @param  \App\Models\WebsiteSlider  $websiteSlider
     * @return void
     */
    public function updated(WebsiteSlider $websiteSlider)
    {
        /*$originalImg=$websiteSlider->getOriginal('img');
        if($websiteSlider->img!=$websiteSlider->getOriginal($originalImg))
            if(File::exists(public_path($originalImg)))
                File::delete(public_path($originalImg));*/
    }

    /**
     * Handle the WebsiteSlider "deleted" event.
     *
     * @param  \App\Models\WebsiteSlider  $websiteSlider
     * @return void
     */
    public function deleted(WebsiteSlider $websiteSlider)
    {
        $originalImg=$websiteSlider->img;
            if(File::exists(public_path($originalImg)))
                File::delete(public_path($originalImg));
    }

    /**
     * Handle the WebsiteSlider "restored" event.
     *
     * @param  \App\Models\WebsiteSlider  $websiteSlider
     * @return void
     */
    public function restored(WebsiteSlider $websiteSlider)
    {
        //
    }

    /**
     * Handle the WebsiteSlider "force deleted" event.
     *
     * @param  \App\Models\WebsiteSlider  $websiteSlider
     * @return void
     */
    public function forceDeleted(WebsiteSlider $websiteSlider)
    {
        //
    }
}
