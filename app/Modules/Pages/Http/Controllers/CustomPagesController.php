<?php namespace App\Modules\Pages\Http\Controllers;

use App\Modules\Pages\CustomPage;
use URL, HTML, FrontController;

class CustomPagesController extends FrontController {

    public function __construct()
    {
        $this->modelName = 'CustomPage';

        parent::__construct();
    }

    /**
     * Show a custom page
     * 
     * @param int      $id          The ID of the custom page
     * @param string   $slug        The unique slug
     * @param boolean  $isImpressum If true, render some special information
     * @return void
     */
    public function show($id, $slug = null, $isImpressum = false)
    {
        if ($id) {
            $customPage = CustomPage::whereId($id)->published()->first();    
        } else {
            $customPage = CustomPage::whereSlug($slug)->published()->first();    
        }        

        $hasAccess = (user() and user()->hasAccess('internal'));
        if ($customPage->internal and ! $hasAccess) {
            return $this->alertError(trans('app.access_denied'));
        }

        $customPage->access_counter++;
        $customPage->save();

        $this->title($customPage->title);
        $this->pageView('pages::show_custom_page', compact('customPage', 'isImpressum'));
    }

    /**
     * Show a custom page by slug instead of ID
     * 
     * @param  string $slug The unique slug
     * @return void
     */
    public function showBySlug($slug)
    {
        $this->show(null, $slug);
    }

    /**
     * Show the default impressum page that includes
     * infos about the CMS.
     * Note: Don't call it "imprint"!
     * 
     * @return void
     */
    public function showTerms()
    {
        return $this->show(1, null, true);
    }

}