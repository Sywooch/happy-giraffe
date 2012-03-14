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
 * @property string $response_id
 * @property string $quote_id
 * @property string $quote_text
 * @property string $position
 * @property string $removed
 *
 * @property User author
 */
class Comment extends CActiveRecord
{
    public $selectable_quote = false;
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
			array('author_id, entity_id, response_id, quote_id', 'length', 'max'=>11),
			array('entity', 'length', 'max'=>255),
            array('position, quote_text, selectable_quote', 'safe'),
            array('removed', 'boolean'),
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
            'response' => array(self::BELONGS_TO, 'Comment', 'response_id'),
            'quote' => array(self::BELONGS_TO, 'Comment', 'quote_id'),
            'remove' => array(self::HAS_ONE, 'Removed', 'entity_id', 'condition' => '`remove`.`entity` = :entity', 'params' => array(':entity' => get_class($this)))
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
            'response_id' => 'Response id',
            'quote_id' => 'Quote id',
            'quote_text' => 'Quote text',
            'position' => 'Позиция',
            'removed' => 'Удален',
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
        $criteria->compare('response_id',$this->response_id,true);
        $criteria->compare('quote_id',$this->quote_id,true);
        $criteria->compare('removed',$this->removed,true);

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
				'pageSize' => 10,
			),
		));
	}

    public function afterSave()
    {
        if ($this->isNewRecord) {
            //проверяем на предмет выполненного модератором задания
            UserSignal::CheckComment($this);

            if (in_array($this->entity, array('CommunityContent', 'RecipeBookRecipe', 'User')))
            {
                $entity = CActiveRecord::model($this->entity)->findByPk($this->entity_id);
                UserNotification::model()->create(UserNotification::NEW_COMMENT, array('comment' => $this));
            }

            //добавляем баллы
            Yii::import('site.frontend.modules.scores.models.*');
            UserScores::addScores($this->author_id, ScoreActions::ACTION_OWN_COMMENT, 1, array(
                'id'=>$this->entity_id, 'name'=>$this->entity));
        }
        parent::afterSave();
    }

    public function beforeSave()
    {
        /* Вырезка цитаты */
        $find = '/<div class="quote">(.*)<\/div>/ims';
        preg_match($find, $this->text, $matches);
        if(count($matches) > 0)
        {
            $this->text = preg_replace($find, '', $this->text);
            if($this->selectable_quote == 1)
            {
                $this->quote_text = $matches[1];
            }
        }
        else
        {
            $this->quote_text = '';
            $this->quote_id = null;
        }

        if($this->response_id == '')
            $this->response_id = null;


        if($this->isNewRecord)
        {
            $criteria = new CDbCriteria(array(
                'select' => 'position',
                'order' => 'created DESC',
                'limit' => 1,
                'condition' => 'entity = :entity and entity_id = :entity_id',
                'params' => array(':entity' => $this->entity, ':entity_id' => $this->entity_id)
            ));
            $model = Comment::model()->find($criteria);
            if(!$model)
                $position = 1;
            else
                $position = $model->position + 1;
            $this->position = $position;
        }
        return parent::beforeSave();
    }

    public function beforeDelete()
    {
        Comment::model()->updateByPk($this->id, array('removed' => 1));
        //вычитаем баллы
        Yii::import('site.frontend.modules.scores.models.*');
        UserScores::removeScores($this->author_id, ScoreActions::ACTION_OWN_COMMENT, 1, array(
            'id'=>$this->entity_id, 'name'=>$this->entity));

        return false;
    }

    public function afterDelete()
    {
        $this->renewPosition();
        parent::afterDelete();
    }

    public static function getUserAvarageCommentsCount($user)
    {
        $comments_count = Comment::model()->count('author_id='.$user->id);
        $days = ceil(strtotime(date("Y-m-d H:i:s")) - strtotime($user->register_date)/86400);
        if ($days == 0)
            $days = 1;

        return round($comments_count/$days);
    }


    /**
     * Пересчитывает позиции группы коментариев внутри сущности
     */
    public function renewPosition()
    {
        $criteria = new CDbCriteria(array(
            'select' => '*',
            'order' => 'created ASC',
            'condition' => 'entity = :entity and entity_id = :entity_id',
            'params' => array(':entity' => $this->entity, ':entity_id' => $this->entity_id)
        ));
        $index = 0;
        $comments = Comment::model()->findAll($criteria);
        foreach($comments as $model)
        {
            $index++;
            $model->position = $index;
            $model->save();
        }
    }

    /**
     * @static
     * Пересчитывает позиции ВСЕХ комментариев
     */
    public static function updateComments()
    {
        $criteria = new CDbCriteria;
        $criteria->group = 'entity, entity_id';
        $criteria->select = '*';
        $comments = Comment::model()->findAll($criteria);
        foreach($comments as $c)
        {
            $cr = new CDbCriteria;
            $cr->condition = 'entity = :entity and entity_id = :entity_id';
            $cr->params = array(':entity' => $c->entity, ':entity_id' => $c->entity_id);
            $cr->order = 'created ASC';
            $comment = Comment::model()->findAll($cr);
            $index = 0;
            foreach($comment as $km)
            {
                $index++;
                $km->position = $index;
                $km->save();
            }
        }
    }
}