<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 5/16/13
 * Time: 3:38 PM
 * To change this template use File | Settings | File Templates.
 */
class FavouriteWidget extends CWidget
{
    public $registerScripts = false;
    public $model;

    public function run()
    {
        $this->registerScripts();
        if ($this->registerScripts)
            return;

        $id = 'Favourites_' . get_class($this->model) . '_' . $this->model->id;

        $count = (int) Favourite::model()->getCountByModel($this->model);
        $active = (bool) Favourite::model()->getUserHas(Yii::app()->user->id, $this->model);
        $entity = get_class($this->model);
        $entityId = $this->model->id;
        $data = compact('count', 'active', 'entity', 'entityId');

        $this->render('index', compact('id', 'data'));
    }

    public function registerScripts()
    {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript
            ->registerScriptFile('/javascripts/knockout-2.2.1.js')
            ->registerScriptFile($baseUrl . '/FavouriteWidget.js')
        ;
    }
}
