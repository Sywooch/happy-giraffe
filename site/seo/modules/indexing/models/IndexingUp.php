<?php

/**
 * This is the model class for table "indexing__ups".
 *
 * The followings are the available columns in table 'indexing__ups':
 * @property string $id
 * @property string $date
 *
 * The followings are the available model relations:
 * @property IndexingUpUrl[] $urls
 */
class IndexingUp extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return IndexingUp the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'happy_giraffe_seo.indexing__ups';
    }

    public function getDbConnection()
    {
        return Yii::app()->db_seo;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date', 'required'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, date', 'safe', 'on' => 'search'),
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
            'urls' => array(self::HAS_MANY, 'IndexingUpUrl', 'up_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'date' => 'Date',
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
        $criteria->compare('date', $this->date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function defaultScope()
    {
        return array(
            'order' => $this->getTableAlias(false, false) .'.id desc',
        );
    }

    public function beforeSave()
    {
        $exist = self::model()->find('date = "'.$this->date.'"');
        if ($exist !== null)
            return false;
        return parent::beforeSave();
    }

    public function getUrls($plus)
    {
        $prev_up = $this->getPrevUp();
        if ($prev_up == null)
            return ($plus) ? $this->urls : array();

        $change = array();
        if ($plus) {
            foreach ($this->urls as $url)
                if (!$prev_up->hasUrl($url->url_id))
                    $change [] = $url;
        } else {
            foreach ($prev_up->urls as $url)
                if (!$this->hasUrl($url->url_id))
                    $change [] = $url;
        }

        return $change;
    }

    public function hasUrl($id)
    {
        foreach ($this->urls as $url)
            if ($url->url_id == $id)
                return true;
        return false;
    }

    public function getPrevUp()
    {
        $criteria = new CDbCriteria;
        $criteria->order = 't.id desc';
        $criteria->condition = ' t.id < ' . $this->id;
        $criteria->with = array('urls', 'urls.url');

        return IndexingUp::model()->find($criteria);
    }
}