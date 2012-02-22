<?php

/**
 * This is the model class for table "report".
 *
 * The followings are the available columns in table 'report':
 * @property string $id
 * @property string $type
 * @property string $text
 * @property string $author_id
 * @property string $model
 * @property string $object_id
 * @property string $path
 * @property string $created
 * @property string $updated
 */
class Report extends CActiveRecord
{
    public $types = array(
        'Спам',
        'Оскорбление пользователей',
        'Разжигание межнациональной розни',
        'Другое',
    );
	/**
	 * Returns the static model of the specified AR class.
	 * @return Report the static model class
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
		return '{{report}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, text, model, object_id', 'required'),
			array('type', 'length', 'max'=>62),
			array('author_id, object_id', 'length', 'max'=>11),
			array('model', 'length', 'max'=>255),
            array('path, created, updated', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, text, author_id, model, object_id', 'safe', 'on'=>'search'),
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
		);
	}

    /**
     * @return array
     */
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

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'type' => 'Type',
			'text' => 'Text',
			'author_id' => 'Informer',
			'model' => 'Model',
			'object_id' => 'Object',
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
		$criteria->compare('type',$this->type,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('author_id',$this->author_id,true);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('object_id',$this->object_id,true);
        $criteria->compare('path',$this->path,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}