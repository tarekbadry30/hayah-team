<?php

namespace App\Observers;

use App\Models\MobileSlider;
use Illuminate\Support\Facades\File;

class MobileSliderObserver
{
    /**
     * Handle the MobileSlider "created" event.
     *
     * @param  \App\Models\MobileSlider  $mobileSlider
     * @return void
     */
    public function created(MobileSlider $mobileSlider)
    {
        //
    }

    /**
     * Handle the MobileSlider "updated" event.
     *
     * @param  \App\Models\MobileSlider  $mobileSlider
     * @return void
     */
    public function updated(MobileSlider $mobileSlider)
    {
        /*$originalImg=$mobileSlider->getOriginal('img');
        if($mobileSlider->img!=$mobileSlider->getOriginal($originalImg))
            if(File::exists(public_path($originalImg)))
                File::delete(public_path($originalImg));*/
    }

    /**
     * Handle the MobileSlider "deleted" event.
     *
     * @param  \App\Models\MobileSlider  $mobileSlider
     * @return void
     */
    public function deleted(MobileSlider $mobileSlider)
    {
        $originalImg=$mobileSlider->img;
            if(File::exists(public_path($originalImg)))
                File::delete(public_path($originalImg));
    }

    /**
     * Handle the MobileSlider "restored" event.
     *
     * @param  \App\Models\MobileSlider  $mobileSlider
     * @return void
     */
    public function restored(MobileSlider $mobileSlider)
    {
        //
    }

    /**
     * Handle the MobileSlider "force deleted" event.
     *
     * @param  \App\Models\MobileSlider  $mobileSlider
     * @return void
     */
    public function forceDeleted(MobileSlider $mobileSlider)
    {
        //
    }
}
