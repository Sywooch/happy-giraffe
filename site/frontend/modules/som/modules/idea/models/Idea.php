<?php

namespace site\frontend\modules\som\modules\idea\models;

use site\frontend\modules\som\modules\photopost\models\Photopost;
use site\frontend\modules\photo\models\PhotoCollection;

class Idea extends Photopost
{
    public $club;
    public $forums = array();
    public $rubrics = array();

    public $labelsArray;

    public function tableName()
    {
        return 'som__idea';
    }

    public function behaviors()
    {
        return array(
            'CacheDelete' => array(
                'class' => 'site\frontend\modules\v1\behaviors\CacheDeleteBehavior',
            ),
            'LabelsConstruct' => array(
                'class' => 'site\frontend\modules\som\modules\idea\behaviors\LabelsConstructBehavior',
                'club' => $this->club,
                'forums' => $this->forums,
                'rubrics' => $this->rubrics,
            ),
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

    public function relations()
    {
        return array(
            'collection' => array(self::BELONGS_TO, get_class(PhotoCollection::model()), 'collectionId'),
            'author' => array(self::BELONGS_TO, get_class(\User::model()), 'authorId'),
        );
    }
}