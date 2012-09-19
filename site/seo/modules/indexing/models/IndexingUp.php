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
    public $text_urls = array();

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
        return 'indexing__ups';
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
            'order' => $this->getTableAlias(false, false) . '.id desc',
        );
    }

    public function beforeSave()
    {
        $exist = self::model()->find('date = "' . $this->date . '"');
        if ($exist !== null)
            return false;
        return parent::beforeSave();
    }

    public function getUrls($plus)
    {
        if (empty($this->text_urls))
            $this->getUpUrls();
        $prev_up = $this->getPrevUp();
        if ($prev_up == null)
            return ($plus) ? $this->text_urls : array();

        if (empty($prev_up->text_urls))
            $prev_up->getUpUrls();

        $change = array();
        if ($plus) {
            foreach ($this->text_urls as $url)
                if (!$prev_up->hasUrl($url))
                    $change [] = $url;
        } else {
            foreach ($prev_up->text_urls as $url)
                if (!$this->hasUrl($url))
                    $change [] = $url;
        }

        return $change;
    }

    public function hasUrl($find_url)
    {
        return in_array($find_url, $this->text_urls);
    }

    /**
     * @return IndexingUp
     */
    public function getPrevUp()
    {
        $criteria = new CDbCriteria;
        $criteria->order = 't.id desc';
        $criteria->condition = ' t.id < ' . $this->id;

        return IndexingUp::model()->find($criteria);
    }

    public function getUpUrls()
    {
        $data = Yii::app()->db_seo->createCommand()
            ->select('t2.id, t2.url')
            ->from('indexing__up_urls as t')
            ->where('up_id = ' . $this->id)
            ->join('indexing__urls as t2', 't.url_id = t2.id')
            ->queryAll();

        $this->text_urls = array();
        foreach($data as $row){
            $this->text_urls[$row['id']] = $row['url'];
        }
    }
}