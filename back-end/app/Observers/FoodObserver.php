<?php

namespace App\Observers;

use App\Models\Food;
use Illuminate\Support\Facades\File;

class FoodObserver
{
    /**
     * Handle the Food "created" event.
     *
     * @param  \App\Models\Food  $food
     * @return void
     */
    public function created(Food $food)
    {
        //
    }

    /**
     * Handle the Food "updated" event.
     *
     * @param  \App\Models\Food  $food
     * @return void
     */
    public function updated(Food $food)
    {
         /*$originalImg=$food->getOriginal('img');
         //dd($food->getOriginal($originalImg));
        if($food->img!=$food->getOriginal($originalImg))
            if(File::exists(public_path($originalImg)))
                File::delete(public_path($originalImg));*/
    }

    /**
     * Handle the Food "deleted" event.
     *
     * @param  \App\Models\Food  $food
     * @return void
     */
    public function deleted(Food $food)
    {
        $originalImg=$food->img;
            if(File::exists(public_path($originalImg)))
                File::delete(public_path($originalImg));
    }

    /**
     * Handle the Food "restored" event.
     *
     * @param  \App\Models\Food  $food
     * @return void
     */
    public function restored(Food $food)
    {
        //
    }

    /**
     * Handle the Food "force deleted" event.
     *
     * @param  \App\Models\Food  $food
     * @return void
     */
    public function forceDeleted(Food $food)
    {
        //
    }
}
