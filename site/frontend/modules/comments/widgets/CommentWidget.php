<?php

namespace site\frontend\modules\comments\widgets;

/**
 * Виджет, предназначенный для вывода комментариев
 *
 * @author Кирилл
 */
class CommentWidget extends \CWidget
{

    public $model;

    public function run()
    {
        // $this->render('commentWidget', array('dataProvider' => $this->dataProvider));
        \Yii::app()->clientScript->registerAMD('Realplexor-reg', array('common', 'comet'), 'comet.connect(\'http://' . \Yii::app()->comet->host . '\', \'' . \Yii::app()->comet->namespace . '\', \'' . \UserCache::GetCurrentUserCache() . '\');');
        \Yii::app()->clientScript->registerAMD('comment-widget', array('kow'));
        echo '<comment-widget class="comment-widget" style="display: block;" params="entity: \'' . get_class($this->model) . '\', entityId: \'' . $this->model->id . '\', listType: \'list\', channelId: \'' .\site\frontend\modules\comments\models\Comment::getChannel($this->model) . '\'"></comment-widget>';
    }

    public function getCount()
    {
        return \Comment::model()->byEntity($this->model)->count();
    }

    public function getDataProvider()
    {
        return new \CActiveDataProvider(\Comment::model()->byEntity($this->model)->specialSort());
    }

    public function getUserLink($user)
    {
        return $user->deleted ?
            \CHtml::tag('span', array('rel' => 'author', 'class' => 'a-light comments_author'), $user->fullName) :
            \CHtml::link($user->fullName, $user->url, array('rel' => 'author', 'class' => 'a-light comments_author'));
    }

}

?>
