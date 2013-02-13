<?php

/**
 * This is the model class for table "seo__keyword_groups".
 *
 * The followings are the available columns in table 'seo__keyword_groups':
 * @property string $id
 *
 * The followings are the available model relations:
 * @property Page $page
 * @property Keyword[] $keywords
 * @property SeoTask[] $seoTasks
 * @property int $newTaskCount
 * @property int $taskCount
 */
class KeywordGroup extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KeywordGroup the static model class
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
        return 'keyword_groups';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('id', 'safe', 'on' => 'search'),
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
            'page' => array(self::HAS_ONE, 'Page', 'keyword_group_id'),
            'keywords' => array(self::MANY_MANY, 'Keyword', 'happy_giraffe_seo.keyword_group_keywords(group_id, keyword_id)'),
            'seoTasks' => array(self::HAS_MANY, 'SeoTask', 'keyword_group_id'),
            'newTasks' => array(self::HAS_MANY, 'SeoTask', 'keyword_group_id', 'condition' => 'status = 0 OR status = 1'),
            'newTaskCount' => array(self::STAT, 'SeoTask', 'keyword_group_id', 'condition' => 'status = 0 OR status = 1'),
            'taskCount' => array(self::STAT, 'SeoTask', 'keyword_group_id'),
        );
    }

    public function behaviors()
    {
        return array(
            'withRelated' => array(
                'class' => 'site.common.extensions.wr.WithRelatedBehavior',
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function addKeyword($keyword_id)
    {
        foreach ($this->keywords as $keyword)
            if ($keyword->id == $keyword_id)
                return ;

        Yii::app()->db_seo->createCommand()->insert('keyword_group_keywords', array(
            'keyword_id' => $keyword_id,
            'group_id' => $this->id
        ));
    }

    public function removeKeyword($keyword_id)
    {
        Yii::app()->db_seo->createCommand()->delete('keyword_group_keywords',
            'keyword_id = :keyword_id AND group_id=:group_id', array(
                ':group_id' => $this->id,
                ':keyword_id' => $keyword_id
            ));
    }

    public function checkGroups()
    {
        $groups = KeywordGroup::model()->findAll();
        foreach($groups as $group){
            if (empty($group->page) && empty($group->seoTasks))
                $group->delete();
        }
    }
}