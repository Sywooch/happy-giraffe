<?php

/**
 * This is the model class for table "linking_pages".
 *
 * The followings are the available columns in table 'linking_pages':
 * @property string $id
 * @property string $entity
 * @property string $entity_id
 *
 * The followings are the available model relations:
 * @property LinkingPagesPages[] $linkingTo
 * @property LinkingPagesPages[] $linkingFrom
 */
class LinkingPages extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LinkingPages the static model class
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
		return 'linking_pages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('entity, entity_id', 'required'),
			array('entity', 'length', 'max'=>16),
			array('entity_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, entity, entity_id', 'safe', 'on'=>'search'),
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
			'linkingTo' => array(self::HAS_MANY, 'LinkingPagesPages', 'page_id'),
			'linkingFrom' => array(self::HAS_MANY, 'LinkingPagesPages', 'linkto_page_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'entity' => 'Entity',
			'entity_id' => 'Entity',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('entity',$this->entity,true);
		$criteria->compare('entity_id',$this->entity_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getPageUrl()
    {
        $model = CActiveRecord::model($this->entity)->findByPk($this->entity_id);
        if ($model === null)
            return null;
        return $model->url;
    }
}