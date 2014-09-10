<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 12/08/14
 * Time: 12:01
 */

class WaypointsTableWidget extends CWidget
{
    /**
     * @var Route
     */
    public $route;

    public function run()
    {
        $this->render('WaypointsTableWidget');
    }
} 