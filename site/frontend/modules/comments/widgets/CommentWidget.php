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

    public function getUserLink($user, $response = false)
    {
        if (!$response)
        {
            return $user->deleted ?
                \CHtml::tag('span', array('rel' => 'author', 'class' => 'a-light comments_author'), $user->fullName) :
                \CHtml::link($user->fullName, $user->url, array('rel' => 'author', 'class' => 'a-light comments_author'));
        }
        else
        {
            return $user->deleted ?
                \CHtml::tag('span', array('rel' => 'author', 'class' => 'a-light comments_ansver-for'), $user->fullName) :
                \CHtml::link($user->fullName, $user->url, array('rel' => 'author', 'class' => 'comments_ansver-for'));
        }
    }

    public function normalizeText($text)
    {
        $matches = array();
        // вырежем обращение из текста
        if (preg_match('~^<p>(<a href="(/user/\d+/)">([^<]+)</a>, )~', $text, $matches))
        {
            //$text = substr_replace($text, '<p><span class="display-n">' . $matches[1] . '</span>', 0, strlen($matches[0]));
            $text = substr_replace($text, '<p>', 0, strlen($matches[0]));
        }

        return $text;
    }

}

?>
