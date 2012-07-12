<?php

/**
 * This is the model class for table "report".
 *
 * The followings are the available columns in table 'report':
 * @property string $id
 * @property string $type
 * @property string $text
 * @property string $author_id
 * @property string $breaker_id
 * @property string $entity
 * @property string $entity_id
 * @property string $path
 * @property int $accepted
 * @property string $created
 * @property string $updated
 * @property CActiveRecord $model
 */
class Report extends HActiveRecord
{
    public $count;
    public $types = array(
        'Спам',
        'Оскорбление пользователей',
        'Разжигание межнациональной розни',
        'Другое',
    );

    public $accepted_types = array(
        'Нет',
        'Да',
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
		return 'reports';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, text, entity, entity_id', 'required'),
			array('type', 'length', 'max'=>62),
			array('author_id, entity_id', 'length', 'max'=>11),
			array('entity', 'length', 'max'=>255),
            array('path, created, updated, breaker_id', 'safe'),
            array('accepted', 'boolean'),
            // The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, text, author_id, breaker_id, entity, entity_id, accepted', 'safe', 'on'=>'search'),
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
            'author' => array(self::BELONGS_TO, 'User', 'author_id'),
            'breaker' => array(self::BELONGS_TO, 'User', 'breaker_id'),
            'spam' => array(self::HAS_MANY, 'ReportSpam', 'report_id'),
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
			'id' => '#',
			'type' => 'Тип жалобы',
			'text' => 'Комментарий пользователя',
			'author_id' => 'Автор',
            'breaker_id' => 'Нарушитель',
			'entity' => 'Model',
			'entity_id' => 'Object',
            'path' => 'Ссылка',
            'created' => 'Создана',
            'updated' => 'Изменена',
            'accepted' => 'Рассмотрено',
            'count' => 'Жалоб',
		);
	}

    public function getModel()
    {
        return call_user_func(array($this->entity, 'model'))->findByPk($this->entity_id);
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
        if($this->type !== null)
            $criteria->compare('type',$this->type,true);
        else
            $criteria->addCondition('type != 0');
        $criteria->compare('text',$this->text,true);
        $criteria->compare('author_id',$this->author_id,true);
        $criteria->compare('breaker_id', $this->breaker_id, true);
        //$criteria->compare('entity',$this->model,true);
        //$criteria->compare('entity_id',$this->object_id,true);
        $criteria->compare('path',$this->path,true);
        $criteria->compare('accepted',$this->accepted,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function spam()
    {
        $dataProvider = $this->search();

        $criteria = $dataProvider->getCriteria();
        $criteria->group = 't.breaker_id';
        $criteria->select = 't.id, t.breaker_id, t.accepted, count(*) as count, max(created) as created';
        $criteria->order = 't.created desc';

        $dataProvider->criteria = $criteria;
        return $dataProvider;
    }

    public function beforeSave()
    {
        if($this->isNewRecord)
            $this->breaker_id = $this->model->author_id;
        return parent::beforeSave();
    }
}