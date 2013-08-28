<?php
/**
 * Class RepostWidget
 *
 * Виджет репоста записи, копирован из виджета избранного
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class RepostWidget extends CWidget
{
    public $right = false;
    /**
     * @var CommunityContent
     */
    public $model;
    public $applyBindings = true;

    public function run()
    {
        $this->registerScripts();
        $count = (int) $this->model->sourceCount;
        $modelName = get_class($this->model);
        $modelId = $this->model->id;
        $entity = Favourite::model()->getEntityByModel($modelName, $modelId);
        if (! Yii::app()->user->isGuest) {
            $id = 'Repost_' . get_class($this->model) . '_' . $this->model->id;
            $active = (bool) $this->model->userReposted(Yii::app()->user->id);
            $ownContent = $this->model->author_id == Yii::app()->user->id;
            $json = compact('count', 'active', 'modelName', 'modelId', 'entity', 'ownContent');
            $data = compact('id', 'json');
        } else
            $data = compact('count');

        $this->render($this->getViewByEntity($entity), $data);
    }

    public function registerScripts()
    {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript
            ->registerScriptFile($baseUrl . '/RepostWidget.js')
        ;
    }

    protected function getViewByEntity($entity) {
        return ($entity == 'cook') ? 'cook' : 'index';
    }
}
