<?php namespace App\Modules\Visitors\Controllers;

use App\Modules\Visitors\Models\Chart;
use BackController;

class AdminVisitorsController extends BackController {

    protected $icon = 'chart_bar.png';

    public function index()
    {
        $chart = new Chart();

        $this->pageView('visitors::admin_show', compact('chart'));
    }

}