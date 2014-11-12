<?php

namespace site\frontend\modules\comments\widgets;

use site\frontend\modules\comments\models\Comment;

/**
 * Виджет, предназначенный для вывода комментариев
 *
 * @author Кирилл
 */
class CommentWidget extends \CWidget
{

    public $model;
    protected $_count = null;

    public function run()
    {
        if (\Yii::app()->user->isGuest)
            $this->runForGuest();
        else
            $this->runForUser();
    }

    public function getCount()
    {
        if (is_null($this->_count))
            $this->_count = Comment::model()->byEntity($this->model)->count();
        return $this->_count;
    }

    public function getDataProvider()
    {
        return new \CActiveDataProvider(Comment::model()->byEntity($this->model)->specialSort(), array('pagination' => false));
    }

    public function getUserLink($user, $response = false)
    {
        if (!$response) {
            return $user->deleted ?
                \CHtml::tag('span', array('rel' => 'author', 'class' => 'a-light comments_author'), $user->fullName) :
                \CHtml::link($user->fullName, $user->url, array('rel' => 'author', 'class' => 'a-light comments_author'));
        }
        else {
            return $user->deleted ?
                \CHtml::tag('span', array('rel' => 'author', 'class' => 'a-light comments_ansver-for'), $user->fullName) :
                \CHtml::link($user->fullName, $user->url, array('rel' => 'author', 'class' => 'comments_ansver-for'));
        }
    }

    public function normalizeText($text)
    {
        $matches = array();
        // вырежем обращение из текста
        if (strpos($text, '<p><a href="/user/') === 0) {
            $pos = strpos($text, '</a>');
            //$text = substr_replace($text, '<p><span class="display-n">' . $matches[1] . '</span>', 0, strlen($matches[0]));
            //$text = substr_replace($text, '<p>', 0, strlen($matches[0]));
            $text = substr_replace($text, '', 3, $pos + 2);
        }

        return $text;
    }

    public function runForGuest()
    {
        $this->render('commentWidget', array('dataProvider' => $this->dataProvider));
    }

    public function runForUser()
    {
        \Yii::app()->clientScript->registerAMD('comment-widget', array('kow'));
        if (!is_array($this->model)) {
            $params = array(
                'entity' => get_class($entity),
                'entityId' => $entity->id,
            );
        }
        else {
            $params = array(
                'entity' => $this->model['entity'],
                'entityId' => (int) $this->model['entity_id'],
            );
        }
        $params['channelId'] = Comment::getChannel($params);
        $params['listType'] = 'list';
        foreach ($params as $k => $v)
            $paramsStr[] = $k . ':' . \CJSON::encode($v);
        $paramsStr = str_replace('"', "'", implode(', ', $paramsStr));
        echo \CHtml::tag('comment-widget', array(
            'class' => 'comment-widget',
            'style' => 'display: block;',
            'params' => $paramsStr,
        ));
        //echo '<comment-widget class="comment-widget" style="display: block;" params="entity: \'' . get_class($this->model) . '\', entityId: \'' . $this->model->id . '\', listType: \'list\', channelId: \'' . \site\frontend\modules\comments\models\Comment::getChannel($this->model) . '\'"></comment-widget>';
    }

}

?>
