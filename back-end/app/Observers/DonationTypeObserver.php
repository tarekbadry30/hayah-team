<?php

namespace App\Observers;

use App\Models\DonationType;
use Illuminate\Support\Facades\File;

class DonationTypeObserver
{
    /**
     * Handle the DonationType "created" event.
     *
     * @param  \App\Models\DonationType  $donationType
     * @return void
     */
    public function created(DonationType $donationType)
    {
        //
    }

    /**
     * Handle the DonationType "updated" event.
     *
     * @param  \App\Models\DonationType  $donationType
     * @return void
     */
    public function updated(DonationType $donationType)
    {
        $originalImg=$donationType->getOriginal('img');
        if($donationType->img!=$donationType->getOriginal($originalImg))
            if(File::exists(public_path($originalImg)))
                File::delete(public_path($originalImg));
    }

    /**
     * Handle the DonationType "deleted" event.
     *
     * @param  \App\Models\DonationType  $donationType
     * @return void
     */
    public function deleted(DonationType $donationType)
    {
        $originalImg=$donationType->img;
            if(File::exists(public_path($originalImg)))
                File::delete(public_path($originalImg));
    }

    /**
     * Handle the DonationType "restored" event.
     *
     * @param  \App\Models\DonationType  $donationType
     * @return void
     */
    public function restored(DonationType $donationType)
    {
        //
    }

    /**
     * Handle the DonationType "force deleted" event.
     *
     * @param  \App\Models\DonationType  $donationType
     * @return void
     */
    public function forceDeleted(DonationType $donationType)
    {
        //
    }
}
