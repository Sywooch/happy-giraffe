<?php

/**
 * This is the model class for table "temp_keywords".
 *
 * The followings are the available columns in table 'temp_keywords':
 * @property integer $keyword_id
 * @property string $owner_id
 * @property integer $section
 *
 * The followings are the available model relations:
 * @property Keyword $keyword
 * @property SeoUser $owner
 */
class TempKeyword extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TempKeyword the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'temp_keywords';
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
			array('keyword_id, owner_id', 'required'),
			array('keyword_id, section', 'numerical', 'integerOnly'=>true),
			array('owner_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('keyword_id, owner_id', 'safe', 'on'=>'search'),
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
			'keyword' => array(self::BELONGS_TO, 'Keyword', 'keyword_id'),
			'owner' => array(self::BELONGS_TO, 'SeoUser', 'owner_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'keyword_id' => 'Keyword',
			'owner_id' => 'Owner',
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

		$criteria=new CDbCriteria;

		$criteria->compare('keyword_id',$this->keyword_id);
		$criteria->compare('owner_id',$this->owner_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public static function filterBusyKeywords()
    {
        /*$tempKeywords = TempKeyword::model()->findAll('owner_id=' . Yii::app()->user->id);
        foreach ($tempKeywords as $tempKeyword) {
            if (!empty($tempKeyword->keyword->group)) {
                $success = false;
                foreach ($tempKeyword->keyword->group as $group)
                    if (empty($group->seoTasks) && empty($group->page))
                        $success = $group->delete();

                if (!$success)
                    $tempKeyword->delete();
            }
        }*/
    }
}