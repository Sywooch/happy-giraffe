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
    public $labelsArray;

    public function tableName()
    {
        return 'som__idea';
    }

    public function behaviors()
    {
        return array(
            'CacheDelete' => array(
                'class' => \site\frontend\modules\api\ApiModule::CACHE_DELETE,
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
            'club' => array(self::BELONGS_TO, get_class(\CommunityClub::model()), 'club'),
        );
    }

    public function getUrl()
    {
        return 'idea/' . $this->id;
    }

    public function rules()
    {
        return array(
            array('title, collectionId, authorId, club', 'required'),
            array('isRemoved, labels', 'safe'),
            array('title', 'length', 'max' => 255),
            array('id', 'unique'),
            array('id, collectionId, authorId, club', 'numerical', 'min' => 1, 'integerOnly' => true),
            array('authorId', 'exist', 'attributeName' => 'id', 'className' => get_class(\User::model())),
            array('collectionId', 'exist', 'attributeName' => 'id', 'className' => get_class(PhotoCollection::model())),
            array('club', 'exist', 'attributeName' => 'id', 'className' => get_class(\CommunityClub::model())),
            array('forums, rubrics', 'match', 'allowEmpty' => true, 'pattern' => '/^([0-9]*[,]?)*$/'),
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
            'club' => 'Club',
            'forums' => 'Forums',
            'rubrics' => 'Rubrics',
        );
    }

    public function onAfterSoftDelete()
    {

    }

    public function onAfterSoftRestore()
    {

    }
}