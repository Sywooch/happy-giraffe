<?php

namespace site\frontend\modules\posts\modules\forums\widgets\lastPost;
use site\frontend\components\api\models\User;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;

/**
 * @author Никита
 * @date 27/10/15
 */

class LastPostWidget extends \CWidget
{
    const LIMIT = 5;

    public function run()
    {
        \Yii::beginProfile('last1');
        $posts = Content::model()->byLabels(array(Label::LABEL_FORUMS))->orderDesc()->findAll(array(
            'limit' => self::LIMIT
        ));
        \Yii::endProfile('last1');

        \Yii::beginProfile('last2');
        $users = User::model()->findAllByPk(array_map(function($post) {
            return $post->authorId;
        }, $posts));
        \Yii::endProfile('last2');

        $this->render('view', compact('posts', 'users'));
    }

    public function getUser($id)
    {
        return \site\frontend\components\api\models\User::model()->query('get', array(
            'id' => $id,
            'avatarSize' => \Avatar::SIZE_SMALL,
        ));
    }
}