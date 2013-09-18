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
        if (!Yii::app()->user->isGuest && Yii::app()->user->model->group != UserGroup::USER && Yii::app()->user->model->checkAuthItem('manageFavourites')) {

            $this->registerScripts();
            $this->render('view', array(
                'model' => $this->model
            ));
        }
    }

    public function registerScripts()
    {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript
            ->registerScriptFile($baseUrl . '/' . 'favourites.js');
    }
}