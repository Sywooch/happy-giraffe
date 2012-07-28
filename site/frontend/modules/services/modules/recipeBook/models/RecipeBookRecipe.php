<?php

/**
 * This is the model class for table "recipe_book__recipes".
 *
 * The followings are the available columns in table 'recipe_book__recipes':
 * @property string $id
 * @property string $title
 * @property string $updated
 * @property string $created
 * @property string $disease_id
 * @property string $author_id
 * @property string $text
 *
 * The followings are the available model relations:
 * @property RecipeBookDiseases $disease
 * @property RecipeBookRecipesIngredients[] $recipeBookRecipesIngredients
 */
class RecipeBookRecipe extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RecipeBookRecipe the static model class
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
		return 'recipe_book__recipes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, updated, disease_id, text', 'required'),
			array('title', 'length', 'max'=>255),
			array('disease_id', 'length', 'max'=>11),
			array('author_id', 'length', 'max'=>10),
			array('created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, updated, created, disease_id, author_id, text', 'safe', 'on'=>'search'),
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
			'disease' => array(self::BELONGS_TO, 'RecipeBookDisease', 'disease_id'),
            'author' => array(self::BELONGS_TO, 'User', 'author_id'),
            'commentsCount' => array(self::STAT, 'Comment', 'entity_id', 'condition' => 'entity=:modelName', 'params' => array(':modelName' => get_class($this))),
			'ingredients' => array(self::HAS_MANY, 'RecipeBookRecipeIngredient', 'recipe_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'updated' => 'Updated',
			'created' => 'Created',
			'disease_id' => 'Disease',
			'author_id' => 'Author',
			'text' => 'Text',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('disease_id',$this->disease_id,true);
		$criteria->compare('author_id',$this->author_id,true);
		$criteria->compare('text',$this->text,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getByDisease($disease_id)
    {
        $criteria = new CDbCriteria;
        $criteria->order = 't.created DESC';
        $criteria->with = array('author', 'author.avatar', 'commentsCount', 'disease');
        if ($disease_id !== null)
            $criteria->compare('disease_id', $disease_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function afterSave()
    {
        parent::afterSave();

        if ($this->isNewRecord)
            UserScores::addScores($this->author_id, ScoreActions::ACTION_RECORD, 1, $this);
    }

    public function afterDelete()
    {
        parent::afterDelete();

        UserScores::removeScores($this->author_id, ScoreActions::ACTION_RECORD, 1, $this);
    }

    public function getUrlParams()
    {
        return array(
            '/services/recipeBook/default/view',
            array('id' => $this->id),
        );
    }

    public function getUrl($comments = false, $absolute = false)
    {
        list($route, $params) = $this->urlParams;

        if ($comments)
            $params['#'] = 'comment_list';

        $method = $absolute ? 'createAbsoluteUrl' : 'createUrl';
        return Yii::app()->$method($route, $params);
    }

    public function getNext()
    {
        return $this->find(
            array(
                'condition' => 'disease_id = :disease_id AND id > :id',
                'params' => array(':disease_id' => $this->disease_id, ':id' => $this->id),
                'order' => 't.id',
            )
        );
    }

    public function getPrev()
    {
        return $this->find(
            array(
                'condition' => 'disease_id = :disease_id AND id < :id',
                'params' => array(':disease_id' => $this->disease_id, ':id' => $this->id),
                'order' => 't.id DESC',
            )
        );
    }
}