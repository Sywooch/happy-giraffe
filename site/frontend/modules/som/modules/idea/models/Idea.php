<?php

namespace site\frontend\modules\som\modules\idea\models;

use site\frontend\modules\som\modules\photopost\models\Photopost;

class Idea extends Photopost
{
    public function tableName()
    {
        return 'som__idea';
    }

    public function behaviors()
    {
        return array(
            'softDelete' => array(
                'class' => 'site.common.behaviors.SoftDeleteBehavior',
                'removeAttribute' => 'isRemoved',
            ),
            'HTimestampBehavior' => array(
                'class' => 'HTimestampBehavior',
                'createAttribute' => 'dtimeCreate',
                'updateAttribute' => null,
            ),
            //Это наверняка поправить надо.
            'UrlBehavior' => array(
                'class' => 'site\common\behaviors\UrlBehavior',
                'route' => function($model) {
                    return $model->forumId ? 'posts/community/view' : 'posts/post/view';
                },
                'params' => function($model) {
                    if ($model->forumId) {
                        return array(
                            'forum_id' => $model->forumId,
                            'content_type_slug' => 'idea',
                            'content_id' => $model->id,
                        );
                    } else {
                        return array(
                            'content_type_slug' => 'idea',
                            'user_id' => $model->authorId,
                            'content_id' => $model->id,
                        );
                    }
                },
            ),
            //'ConvertBehavior' => 'site\frontend\modules\som\modules\photopost\behaviors\ConvertBehavior',
        );
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}