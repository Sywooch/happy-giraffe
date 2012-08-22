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
 * @property string $article_title
 * @property integer $type
 * @property integer $status
 * @property string $created
 * @property string $rewrite
 *
 * The followings are the available model relations:
 * @property SeoUser $owner
 * @property KeywordGroup $keywordGroup
 * @property SeoUser $executor
 * @property RewriteUrl[] $rewriteUrls
 */
class SeoTask extends CActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_READY = 1;
    const STATUS_TAKEN = 2;
    const STATUS_WRITTEN = 3;
    const STATUS_CORRECTING = 4;
    const STATUS_CORRECTED = 5;
    const STATUS_PUBLICATION = 6;
    const STATUS_PUBLISHED = 7;
    const STATUS_CLOSED = 8;

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
            'owner' => array(self::BELONGS_TO, 'SeoUser', 'owner_id'),
            'executor' => array(self::BELONGS_TO, 'SeoUser', 'executor_id'),
            'article' => array(self::BELONGS_TO, 'Page', 'article_id'),
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
                'updateAttribute' => null,
            ),
            'TrackableBehavior'
        );
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->status = self::STATUS_NEW;
        } elseif ($this->status != $this->getOldAttribute('status')) {
            $statusDate = new StatusDates();
            $statusDate->status = (int)$this->status;
            $statusDate->entity_id = (int)$this->id;
            $statusDate->entity = get_class($this);
            $statusDate->save();
        }

        if ($this->status == self::STATUS_READY) {
            foreach ($this->keywordGroup->keywords as $keyword)
                TempKeyword::model()->deleteAll('keyword_id=' . $keyword->id);
        }

        return parent::beforeSave();
    }

    public function getText()
    {
        $res = '';
        foreach ($this->keywordGroup->keywords as $key)
            $res .= $key->name . '<br>';
        if ($this->rewrite)
            foreach ($this->rewriteUrls as $url)
                $res .= $url->url . '<br>';
        return trim($res, '<br>');
    }

    public function getHints()
    {
        $res = array();

        $keys = CHtml::listData($this->keywordGroup->keywords, 'id', 'name');

        foreach ($this->keywordGroup->keywords as $key) {
            $hint_keywords = $key->getChildKeywords(20);
            foreach ($hint_keywords as $hint_keyword){
                if (!in_array($hint_keyword->name, $keys))
                    $res[] = $hint_keyword->name;
                if (count($res) >= 10)
                    break(2);
            }
        }

        return implode(', ', $res);
    }

    public static function TodayExecutedTasks()
    {
        $criteria = new CDbCriteria;
        if (Yii::app()->user->checkAccess('author')) {
            $criteria->condition = 'executor_id = :executor_id AND status > ' . SeoTask::STATUS_TAKEN;
            $criteria->params = array('executor_id' => Yii::app()->user->id);

        } elseif (Yii::app()->user->checkAccess('moderator')) {
            $criteria->compare('status >', SeoTask::STATUS_TAKEN);
            $criteria->compare('type', SeoTask::TYPE_MODER);
            $criteria->compare('executor_id', Yii::app()->user->id);

        } elseif (Yii::app()->user->checkAccess('content-manager')) {
            $criteria->condition = 'owner_id = :owner_id AND status > ' . SeoTask::STATUS_PUBLICATION . ' AND type = ' . SeoTask::TYPE_EDITOR;
            $criteria->params = array('owner_id' => Yii::app()->user->getModel()->owner_id);

        } elseif (Yii::app()->user->checkAccess('corrector')) {
            $criteria->condition = 'owner_id = :owner_id AND status > ' . SeoTask::STATUS_CORRECTING . ' AND type = ' . SeoTask::TYPE_EDITOR;
            $criteria->params = array('owner_id' => Yii::app()->user->getModel()->owner_id);

        } elseif (Yii::app()->user->checkAccess('editor')) {
            $criteria->compare('status', SeoTask::STATUS_CLOSED);
            $criteria->compare('owner_id', Yii::app()->user->id);
        }

        return SeoTask::model()->findAll($criteria);
    }

    public static function getTasks()
    {
        $criteria = new CDbCriteria;
        if (Yii::app()->user->checkAccess('author')) {
            $criteria->compare('type', SeoTask::TYPE_EDITOR);
            $criteria->compare('executor_id', Yii::app()->user->id);
            $criteria->compare('status', SeoTask::STATUS_READY);

        } elseif (Yii::app()->user->checkAccess('moderator')) {
            $criteria->compare('type', SeoTask::TYPE_MODER);
            $criteria->compare('status', SeoTask::STATUS_READY);

        } elseif (Yii::app()->user->checkAccess('corrector')) {
            $criteria->compare('type', SeoTask::TYPE_EDITOR);
            $criteria->compare('status', SeoTask::STATUS_CORRECTING);
            $criteria->compare('owner_id', Yii::app()->user->getModel()->owner_id);

        } elseif (Yii::app()->user->checkAccess('content-manager')) {
            $criteria->compare('type', SeoTask::TYPE_EDITOR);
            $criteria->compare('status', SeoTask::STATUS_PUBLICATION);
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

    public function getIcon()
    {
        if ($this->type == self::TYPE_MODER)
            return '<i class="icon-moderator"></i>';
        else
            return '<i class="icon-admin"></i>';
    }

    public function getExecutor()
    {
        if (empty($this->executor_id))
            return $this->getIcon();
        else
            return $this->getIcon() . '<br><span class="admin-name">' . $this->executor->name . '</span>';
    }

    public function getStatusText()
    {
        switch ($this->status) {
            case self::STATUS_READY:
                return 'Новое';
            case self::STATUS_TAKEN:
                return 'Написание';
            case self::STATUS_WRITTEN:
                return 'Статья написана';
            case self::STATUS_CORRECTING:
                return 'На коррекции';
            case self::STATUS_CORRECTED:
                return 'Откорректировано';
            case self::STATUS_PUBLICATION:
                return 'На публикации';
            case self::STATUS_PUBLISHED:
                return 'Опубликована';
            case self::STATUS_CLOSED:
                return 'Проверено';
        }

        return '';
    }

    public function getArticleText()
    {
        $text = '';
        if (!empty($this->article_title))
            $text .= '<b>' . $this->article_title . '</b>';

        if (!empty($this->article_id)) {
            $text .= '<br>' . CHtml::link($this->article->url, $this->article->url);
        }

        return $text;
    }
}