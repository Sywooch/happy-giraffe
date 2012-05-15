<?php

/**
 * This is the model class for table "seo__task".
 *
 * The followings are the available columns in table 'seo__task':
 * @property string $id
 * @property string $executor_id
 * @property string $owner_id
 * @property string $keyword_group_id
 * @property integer $article_id
 * @property integer $type
 * @property integer $status
 * @property string $updated
 * @property string $created
 * @property string $executed
 * @property string $rewrite
 *
 * The followings are the available model relations:
 * @property User $owner
 * @property KeywordGroup $keywordGroup
 * @property User $executor
 * @property RewriteUrl[] $rewriteUrls
 */
class SeoTask extends CActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_TAKEN = 1;
    const STATUS_WRITTEN = 2;
    const STATUS_CHECKED = 3;
    const STATUS_PUBLISHED = 4;
    const STATUS_CLOSED = 5;

    const TYPE_MODER = 1;
    const TYPE_EDITOR = 2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SeoTask the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getDbConnection()
    {
        return Yii::app()->db_seo;
    }

    public function tableName()
    {
        return 'task';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('keyword_group_id', 'required'),
            array('type, status', 'numerical', 'integerOnly' => true),
            array('keyword_group_id, executor_id', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, keyword_group_id, type, status, created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'rewriteUrls' => array(self::HAS_MANY, 'RewriteUrl', 'task_id'),
            'keywordGroup' => array(self::BELONGS_TO, 'KeywordGroup', 'keyword_group_id'),
            'owner' => array(self::BELONGS_TO, 'User', 'owner_id'),
            'executor' => array(self::BELONGS_TO, 'User', 'executor_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'keyword_group_id' => 'Keyword Group',
            'type' => 'Type',
            'status' => 'Status',
            'created' => 'Created',
        );
    }

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
            )
        );
    }

    public function getText()
    {
        $res = '';
        foreach ($this->keywordGroup->keywords as $key)
            $res .= $key->name . ', ';
        if ($this->rewrite)
            foreach($this->rewriteUrls as $url)
                $res .= $url->url . ', ';
        return trim($res, ', ');
    }

    public static function TodayExecutedTasks()
    {
        $criteria = new CDbCriteria;
        if (Yii::app()->user->checkAccess('author')) {
            $criteria->compare('status >', SeoTask::STATUS_NEW);
            $criteria->compare('type', SeoTask::TYPE_EDITOR);
            $criteria->compare('executor_id', Yii::app()->user->id);
            $criteria->compare('executed >', date("Y-m-d") . ' 00:00:00');

        } elseif (Yii::app()->user->checkAccess('moderator')) {
            $criteria->compare('status >', SeoTask::STATUS_TAKEN);
            $criteria->compare('type', SeoTask::TYPE_MODER);
            $criteria->compare('executor_id', Yii::app()->user->id);
            $criteria->compare('executed >', date("Y-m-d") . ' 00:00:00');

        } elseif (Yii::app()->user->checkAccess('content-manager')) {
            $criteria->compare('status >', SeoTask::STATUS_CHECKED);
            $criteria->compare('owner_id', Yii::app()->user->getModel()->owner_id);

        } elseif (Yii::app()->user->checkAccess('editor')) {
            $criteria->compare('status', SeoTask::STATUS_CLOSED);
            $criteria->compare('owner_id', Yii::app()->user->id);

        }
        $criteria->compare('updated >', date("Y-m-d") . ' 00:00:00');

        return SeoTask::model()->findAll($criteria);
    }

    public static function getTasks()
    {
        $criteria = new CDbCriteria;
        if (Yii::app()->user->checkAccess('author')) {
            $criteria->compare('type', SeoTask::TYPE_EDITOR);
            $criteria->compare('executor_id', Yii::app()->user->id);
            $criteria->compare('status', SeoTask::STATUS_NEW);
            $criteria->compare('owner_id', Yii::app()->user->getModel()->owner_id);

        } elseif (Yii::app()->user->checkAccess('moderator')) {
            $criteria->compare('type', SeoTask::TYPE_MODER);
            $criteria->compare('status', SeoTask::STATUS_NEW);

        } elseif (Yii::app()->user->checkAccess('content-manager')) {
            $criteria->compare('type', SeoTask::TYPE_EDITOR);
            $criteria->compare('status', SeoTask::STATUS_CHECKED);
            $criteria->compare('owner_id', Yii::app()->user->getModel()->owner_id);
        }
        $criteria->order = 'created DESC';

        return SeoTask::model()->findAll($criteria);
    }

    public static function getActiveTask()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('status', SeoTask::STATUS_TAKEN);
        $criteria->compare('executor_id', Yii::app()->user->id);
        return SeoTask::model()->find($criteria);
    }
}