<?php

namespace site\frontend\modules\som\modules\idea\models;

use site\frontend\modules\som\modules\photopost\models\Photopost;
use site\frontend\modules\photo\models\PhotoCollection;
use site\frontend\modules\som\modules\idea\behaviors\LabelsConstructBehavior;

/**
 * @property $club;
 * @property $forums;
 * @property $rubrics;
 */
class Idea extends \CActiveRecord
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
                'class' => 'site\frontend\modules\som\modules\idea\behaviors\LabelsConstructBehavior'
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
            /*'UrlBehavior' => array(

                'class' => 'site\common\behaviors\UrlBehavior',
                'route' => function($model) {
                    return $model->forumId ? 'posts/community/view' : 'posts/post/view';
                },
                'params' => function($model) {
                    return array(
                        'content_type_slug' => 'idea',
                        'user_id' => $model->authorId,
                        'content_id' => $model->id,
                    );
                },
            ),*/
            'ConvertBehavior' => 'site\frontend\modules\som\modules\idea\behaviors\ConvertBehavior',
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

    public function getUrl()
    {
        return 'idea/' . $this->id;
    }

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, collectionId, authorId', 'required'),
            array('isRemoved, labels', 'safe'),
            array('title', 'length', 'max' => 255),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Title',
            'collectionId' => 'Collection',
            'authorId' => 'Author',
            'isRemoved' => 'Is Removed',
            'dtimeCreate' => 'Dtime Create',
            'labels' => 'Labels',
        );
    }

    public function onAfterSoftDelete()
    {

    }

    public function onAfterSoftRestore()
    {

    }
}