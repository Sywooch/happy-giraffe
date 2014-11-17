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
    public $cacheId = 'dbCache';
    protected $_count = null;
    private $_actions = array();

    public function run()
    {
        if (\Yii::app()->user->isGuest)
            $this->runForGuest();
        else
            $this->runForUser();
    }

    /**
     * 
     * @return \CCache 
     */
    public function getCacheComponent()
    {
        return \Yii::app()->getComponent($this->cacheId);
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
        // Выполнение виджета для гостя, с кешированием, в качестве зависимости испульзуется кол-во комментариев
        $text = '';
        if (($data = $this->getCacheComponent()->get($this->cacheKey)) && is_array($data)) {
            $this->_actions = $data[1];
            $text = $data[0];
            $this->replayActions();
        }
        else {
            if(!is_array($data)) {
                // Надо удалить старый кеш, который не кешировал регистрацию clientScript
                $this->getCacheComponent()->delete($this->cacheKey);
            }
            
            $this->getController()->getCachingStack()->push($this);
            $text = $this->render('commentWidget', array('dataProvider' => $this->dataProvider), true);
            $this->getController()->getCachingStack()->pop();
            $data = array($text, $this->_actions);
            $this->getCacheComponent()->add($this->cacheKey, $data, 0, $this->getCacheDependency());
        }
        echo $text;
    }

    public function recordAction($context, $method, $params)
    {
        $this->_actions[] = array($context, $method, $params);
    }

    protected function replayActions()
    {
        if (empty($this->_actions))
            return;
        $controller = $this->getController();
        $cs = \Yii::app()->getClientScript();
        foreach ($this->_actions as $action) {
            if ($action[0] === 'clientScript')
                $object = $cs;
            elseif ($action[0] === '')
                $object = $controller;
            else
                $object = $controller->{$action[0]};
            if (method_exists($object, $action[1]))
                call_user_func_array(array($object, $action[1]), $action[2]);
            elseif ($action[0] === '' && function_exists($action[1]))
                call_user_func_array($action[1], $action[2]);
            else
                throw new \CException(Yii::t('yii', 'Unable to replay the action "{object}.{method}". The method does not exist.', array('object' => $action[0],
                    'method' => $action[1])));
        }
    }

    public function getCacheKey()
    {
        if (!is_array($this->model)) {
            $key = get_class($this->model) . $this->model->id;
        }
        else {
            $key = $this->model['entity'] . $this->model['entity_id'];
        }
        return $key;
    }

    public function getCacheDependency()
    {
        return Comment::getCacheDependency($this->model);
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
