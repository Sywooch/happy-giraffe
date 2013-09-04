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
        Yii::app()->clientScript->registerPackage('ko_post');

        $count = (int) $this->model->sourceCount;
        $modelName = get_class($this->model);
        $modelId = $this->model->id;
        $entity = Favourite::model()->getEntityByModel($modelName, $modelId);
        if (! Yii::app()->user->isGuest) {
            $id = 'Repost_' . get_class($this->model) . '_' . $this->model->id;
            $active = (bool) $this->model->userReposted(Yii::app()->user->id);
            $ownContent = $this->model->author_id == Yii::app()->user->id;
            $rubricsList =  array_map(function ($rubric) {
                return array(
                    'id' => $rubric->id,
                    'title' => $rubric->title,
                );
            }, Yii::app()->user->getModel()->blog_rubrics);

            $json = compact('count', 'active', 'modelName', 'modelId', 'entity', 'ownContent', 'rubricsList');
            $data = compact('id', 'json');
        } else
            $data = compact('count');

        $this->render($this->getViewByEntity($entity), $data);
    }

    protected function getViewByEntity($entity) {
        return ($entity == 'cook') ? 'repost_cook' : 'repost';
    }
}
