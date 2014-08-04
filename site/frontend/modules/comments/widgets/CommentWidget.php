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
        $this->render('commentWidget', array('dataProvider' => $this->dataProvider));
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
