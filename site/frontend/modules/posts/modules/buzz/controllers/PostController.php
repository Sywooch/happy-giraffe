<?php
/**
 * @author Никита
 * @date 21/10/15
 */

namespace site\frontend\modules\posts\modules\buzz\controllers;


use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;

class PostController extends \site\frontend\modules\posts\controllers\PostController
{
    public $layout = '/layout';

    protected $_club;

    public function getLeftPost()
    {
        if (is_null($this->_leftPost)) {
            $this->_leftPost = Content::model()->cache(3600)->byLabels(array(Label::LABEL_BUZZ))->leftFor($this->post)->find();
        }

        return $this->_leftPost;
    }

    public function getRightPost()
    {
        if (is_null($this->_rightPost)) {
            $this->_rightPost = Content::model()->cache(3600)->byLabels(array(Label::LABEL_BUZZ))->rightFor($this->post)->find();
        }

        return $this->_rightPost;
    }
}