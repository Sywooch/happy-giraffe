<?php
namespace site\frontend\modules\posts\components;

use site\common\helpers\HStr;

class MailAdapter
{
    /**
     * @var \site\frontend\modules\posts\models\Content
     */
    public $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function getUser()
    {
        return \User::model()->findByPk($this->content->authorId);
    }

    public function getPhoto()
    {
        return $this->content->socialObject->getPreviewPhoto();
    }

    public function getText()
    {
        return HStr::truncate($this->content->socialObject->getPreviewText(), 450);
    }

    public function getComments()
    {
        $widget=\Yii::app()->getComponent('widgetFactory')->createWidget($this,'site\frontend\modules\comments\widgets\CommentWidget', array('model' => array(
            'entity' => $this->content->originService == 'oldBlog' ? 'BlogContent' : $this->content->originEntity,
            'entity_id' => $this->content->originEntityId,
        )));
        $widget->init();
        return $widget;
    }
}