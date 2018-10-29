<?php namespace App\Modules\Adverts\Http\Controllers;

use App\Modules\Adverts\Advert;
use Redirect, FrontController;

class AdvertsController extends FrontController {

    /**
     * Navigate to the URL of an advert
     * 
     * @param  int $id The id of the advert
     * @return Redirect
     */
    public function url($id)
    {
        $advert = Advert::published()->findOrFail($id);

        $advert->access_counter++;
        $advert->save();

        return Redirect::to($advert->url); // Go to advert website
    }

}
