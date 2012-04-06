<?php
/**
 * Author: alexk984
 * Date: 06.04.12
 */
class FavouritesWidget extends CWidget
{
    public $model;

    public function run()
    {
        if (Yii::app()->user->checkAccess('manageFavourites'))
            $this->render('view', array(
                'model' => $this->model
            ));
    }
}