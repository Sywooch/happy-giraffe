<?php

namespace site\frontend\modules\posts\modules\forums\widgets\lastPost;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;

/**
 * @author Никита
 * @date 27/10/15
 */

class LastPostWidget extends \CWidget
{
    const LIMIT = 5;

    public $posts;

    private $_users;

    public function run()
    {
        $this->posts = Content::model()->byLabels(array(Label::LABEL_FORUMS))->orderDesc()->findAll(array(
            'limit' => self::LIMIT
        ));

        $this->render('view');
    }

    public function getUser($id)
    {
        if (! isset($this->_users[$id])) {
            $this->_users[$id] = \site\frontend\components\api\models\User::model()->query('get', array(
                'id' => $id,
                'avatarSize' => \Avatar::SIZE_SMALL,
            ));
        }

        return $this->_users[$id];
    }
}