<?php

namespace App\Observers;

use App\Models\Kit;

class KitObserver
{
    /**
     * Handle the Kit "created" event.
     *
     * @param  \App\Models\Kit  $kit
     * @return void
     */
    public function creating(Kit $kit)
    {
        if($kit->LCN)
            $kit->url = 'http://support.mitechnologiesinc.com/Item/LicensePlate/'.$kit->LCN;
        else {
            $kit->url = 'http://support.mitechnologiesinc.com/Item/LicensePlate/';
        }
    }

//    /**
//     * Handle the Kit "updated" event.
//     *
//     * @param  \App\Models\Kit  $kit
//     * @return void
//     */
//    public function updated(Kit $kit)
//    {
//        //
//    }
//
//    /**
//     * Handle the Kit "deleted" event.
//     *
//     * @param  \App\Models\Kit  $kit
//     * @return void
//     */
//    public function deleted(Kit $kit)
//    {
//        //
//    }
//
//    /**
//     * Handle the Kit "restored" event.
//     *
//     * @param  \App\Models\Kit  $kit
//     * @return void
//     */
//    public function restored(Kit $kit)
//    {
//        //
//    }
//
//    /**
//     * Handle the Kit "force deleted" event.
//     *
//     * @param  \App\Models\Kit  $kit
//     * @return void
//     */
//    public function forceDeleted(Kit $kit)
//    {
//        //
//    }
}
