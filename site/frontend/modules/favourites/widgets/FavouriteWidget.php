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
    public $right = false;
    /**
     * @var CommunityContent
     */
    public $model;
    public $applyBindings = true;
    public $small = false;

    public function run()
    {
        $this->registerScripts();
        if ($this->registerScripts)
            return true;

        $count = (int) Favourite::model()->getCountByModel($this->model);
        $modelName = get_class($this->model);
        if ($modelName == 'CommunityContent' && $this->model->getIsFromBlog())
            $modelName = 'BlogContent';
        elseif($modelName == 'BlogContent' && !$this->model->getIsFromBlog())
            $modelName = 'CommunityContent';

        $modelId = $this->model->id;
        $entity = Favourite::model()->getEntityByModel($this->model);
        if (! Yii::app()->user->isGuest) {
            $id = 'Favourites_' . get_class($this->model) . '_' . $this->model->id;
            $active = (bool) Favourite::model()->getUserHas(Yii::app()->user->id, $this->model);
            $json = compact('count', 'active', 'modelName', 'modelId', 'entity');
            $data = compact('id', 'json');
        } else
            $data = compact('count');

        $this->render($this->getViewByEntity($entity), $data);
    }

    public function registerScripts()
    {
        /* @var $cs ClientScript */
        $cs = Yii::app()->clientScript;
        if ($cs->useAMD) {
            $cs->registerAMD('favouriteWidget', array('ko' => 'knockout'));
        }
        else {
            $cs->registerScriptFile('/javascripts/FavouriteWidget.js');
        }
    }

    protected function getViewByEntity($entity) {
        if ($entity == 'cook')
            return 'cook';
        elseif ($this->small)
            return 'small';
        else
            return 'index';
    }
}
