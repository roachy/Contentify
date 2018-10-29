<?php namespace App\Modules\Shouts\Http\Controllers;

use App\Modules\Shouts\Shout;
use Input, DB, Response, FrontController;

class ShoutsController extends FrontController {

    /**
     * Stores a shout
     * 
     * @return void
     */
    public function store()
    {
        if (! user()) {
            return Response::make(null, 403); // 403: Not allowed
        }

        $this->deleteOld();

        $shout = new Shout(['text' => htmlspecialchars(Input::get('text'))]);
        $shout->creator_id = user()->id;

        $okay = $shout->save();

        if (! $okay) {
            return Response::make(null, 500);
        } else {       
            return Response::make(null, 200);
        }
    }

    /**
     * Deletes all shouts that are not part of the 20 newest shouts
     */
    protected function deleteOld()
    {
        $ids = DB::table('shouts')->orderBy('created_at', 'desc')->take(20)->lists('id');

        $ids[] = 0;

        DB::table('shouts')->whereNotIn('id', $ids)->delete();
    }

}