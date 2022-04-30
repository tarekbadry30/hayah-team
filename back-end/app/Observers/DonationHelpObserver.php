<?php

namespace App\Observers;

use App\Models\DonationHelp;
use Illuminate\Support\Facades\File;

class DonationHelpObserver
{
    /**
     * Handle the DonationHelp "created" event.
     *
     * @param  \App\Models\DonationHelp  $donationHelp
     * @return void
     */
    public function created(DonationHelp $donationHelp)
    {
        //
    }

    /**
     * Handle the DonationHelp "updated" event.
     *
     * @param  \App\Models\DonationHelp  $donationHelp
     * @return void
     */
    public function updated(DonationHelp $donationHelp)
    {
        /*$originalImg=$donationHelp->getOriginal('img');
        if($donationHelp->img!=$donationHelp->getOriginal($originalImg))
            if(File::exists(public_path($originalImg)))
                File::delete(public_path($originalImg));*/
    }

    /**
     * Handle the DonationHelp "deleted" event.
     *
     * @param  \App\Models\DonationHelp  $donationHelp
     * @return void
     */
    public function deleted(DonationHelp $donationHelp)
    {
        $originalImg=$donationHelp->img;
            if(File::exists(public_path($originalImg)))
                File::delete(public_path($originalImg));
    }

    /**
     * Handle the DonationHelp "restored" event.
     *
     * @param  \App\Models\DonationHelp  $donationHelp
     * @return void
     */
    public function restored(DonationHelp $donationHelp)
    {
        //
    }

    /**
     * Handle the DonationHelp "force deleted" event.
     *
     * @param  \App\Models\DonationHelp  $donationHelp
     * @return void
     */
    public function forceDeleted(DonationHelp $donationHelp)
    {
        //
    }
}
