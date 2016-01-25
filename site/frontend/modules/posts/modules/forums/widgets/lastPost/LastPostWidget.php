<?php

namespace site\frontend\modules\posts\modules\forums\widgets\lastPost;
use site\frontend\components\api\models\User;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;
use site\frontend\modules\posts\models\Tag;

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
//        $posts = \Yii::app()->cache->get(__CLASS__);
//        if ($posts === false) {
            $labelId = Label::getIdsByLabels(array(Label::LABEL_FORUMS))[0];
            $dependency = new \CExpressionDependency();
            $posts = Content::model()->byLabels(array(Label::LABEL_FORUMS))->orderDesc()->cache(0, $dependency)->findAll(array(
                'limit' => self::LIMIT,
            ));
//            \Yii::app()->cache->set(__CLASS__, $posts, 0, $dependency);
//        }
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