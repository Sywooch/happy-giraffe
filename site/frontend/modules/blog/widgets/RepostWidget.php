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

    protected function getViewByEntity($entity) {
        return ($entity == 'cook') ? 'cook' : 'index';
    }
}
