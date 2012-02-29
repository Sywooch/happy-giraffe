<?php

/**
 * This is the model class for table "comment".
 *
 * The followings are the available columns in table 'comment':
 * @property string $id
 * @property string $text
 * @property string $created
 * @property string $author_id
 * @property string $entity
 * @property string $entity_id
 * @property string $parent_id
 *
 * @property User author
 */
class Comment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Comment the static model class
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
		return '{{comment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('text, author_id, entity, entity_id', 'required'),
			array('author_id, entity_id, parent_id', 'length', 'max'=>11),
			array('entity', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, text, created, author_id, entity, entity_id', 'safe', 'on'=>'search'),
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
            'parent' => array(self::BELONGS_TO, 'Comment', 'parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'text' => 'Text',
			'created' => 'Created',
			'author_id' => 'Author',
			'entity' => 'Entity',
			'entity_id' => 'Entity PK',
            'parent_id' => 'Parent id',
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
		$criteria->compare('text',$this->text,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('author_id',$this->author_id,true);
		$criteria->compare('entity',$this->entity,true);
		$criteria->compare('entity_id',$this->entity_id,true);
        $criteria->compare('parent_id',$this->parent_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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

    public function afterSave()
    {
        if ($this->isNewRecord){
            //проверяем на предмет выполненного модератором задания
            UserSignal::CheckComment($this);

            if ($this->author->commentsCount == 1){
                //первый комментарий пользователя, сообщаем модераторам
                $signal = new UserSignal;
                $signal->signal_type = UserSignal::TYPE_NEW_USER_COMMENT;
                $signal->user_id = $this->author_id;
                $signal->item_id = $this->id;
                $signal->item_name = 'Comment';
                $signal->save();
            }
        }
        return parent::afterSave();
    }
	
	public function get($entity, $entity_id)
	{
		return new CActiveDataProvider(get_class(), array(
			'criteria' => array(
				'condition' => 'entity=:entity AND entity_id=:entity_id',
				'params' => array(':entity' => $entity, ':entity_id' => $entity_id),
				'with' => array('author'),
				'order' => 'created ASC',
			),
			'pagination' => array(
				'pageSize' => 2,
			),
		));
	}

    public static function getUserAvarageCommentsCount($user)
    {
        $comments_count = Comment::model()->count('author_id='.$user->id);
        $days = ceil(strtotime(date("Y-m-d H:i:s")) - strtotime($user->register_date)/86400);
        if ($days == 0)
            $days = 1;

        return round($comments_count/$days);
    }
}