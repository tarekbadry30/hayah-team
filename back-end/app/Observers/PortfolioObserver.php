<?php

namespace App\Observers;

use App\Models\Portfolio;
use Illuminate\Support\Facades\File;

class PortfolioObserver
{
    /**
     * Handle the Portfolio "created" event.
     *
     * @param  \App\Models\Portfolio  $portfolio
     * @return void
     */
    public function created(Portfolio $portfolio)
    {
        //
    }

    /**
     * Handle the Portfolio "updated" event.
     *
     * @param  \App\Models\Portfolio  $portfolio
     * @return void
     */
    public function updated(Portfolio $portfolio)
    {
        /*$originalImg=$portfolio->getOriginal('img');
        if($portfolio->img!=$portfolio->getOriginal($originalImg))
            if(File::exists(public_path($originalImg)))
                File::delete(public_path($originalImg));*/
    }

    /**
     * Handle the Portfolio "deleted" event.
     *
     * @param  \App\Models\Portfolio  $portfolio
     * @return void
     */
    public function deleted(Portfolio $portfolio)
    {
        $originalImg=$portfolio->img;
            if(File::exists(public_path($originalImg)))
                File::delete(public_path($originalImg));
    }

    /**
     * Handle the Portfolio "restored" event.
     *
     * @param  \App\Models\Portfolio  $portfolio
     * @return void
     */
    public function restored(Portfolio $portfolio)
    {
        //
    }

    /**
     * Handle the Portfolio "force deleted" event.
     *
     * @param  \App\Models\Portfolio  $portfolio
     * @return void
     */
    public function forceDeleted(Portfolio $portfolio)
    {
        //
    }
}
