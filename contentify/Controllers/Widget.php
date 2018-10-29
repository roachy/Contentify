<?php namespace Contentify\Controllers;

abstract class Widget {

	/**
	 * Default limit for DB queries
	 */
	const LIMIT = 5;

    /**
     * Abstract. Renders the widget.
     *
     * @param array $parameters Parameters passed to the widget. Keys should to be strings
     * @return void
     */
    abstract public function render($parameters = array());
    
}