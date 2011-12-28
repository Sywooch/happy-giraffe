<?php

/**
 * This is the model class for table "recipeBook_recipe".
 *
 * The followings are the available columns in table 'recipeBook_recipe':
 * @property string $id
 * @property string $name
 * @property string $disease_id
 * @property string $user_id
 * @property string $text
 * @property string $source_type
 * @property string $internet_link
 * @property string $internet_favicon
 * @property string $internet_title
 * @property string $book_author
 * @property string $book_name
 * @property string $create_time
 * @property integer $views_amount
 * @property integer votes_pro
 * @property integer votes_con
 *
 * The followings are the available model relations:
 * @property User $user
 */
class RecipeBookRecipe extends CActiveRecord
{
	private $_purposeIds = null;
    public $vote;

	public function getPurposeIds()
	{
		if ($this->_purposeIds === null)
		{
			$this->_purposeIds = array();
			if(!$this->isNewRecord)
			{
				foreach($this->purposes as $purpose)
				{
					$this->_purposeIds[] = $purpose->primaryKey;
				}
			}
		}
		return $this->_purposeIds == '' ? array() : $this->_purposeIds;
	}

	public function setPurposeIds($value)
	{
		$this->_purposeIds = $value;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @return RecipeBookRecipe the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors()
	{
		return array('CAdvancedArBehavior' => array('class' => 'application.extensions.CAdvancedArBehavior'));
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'recipeBook_recipe';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, disease_id, purposeIds, text', 'required'),
			array('views_amount', 'numerical', 'integerOnly'=>true),
			array('name, internet_link, internet_favicon, internet_title, book_author, book_name', 'length', 'max'=>255),
			array('disease_id', 'exist', 'attributeName' => 'id', 'className' => 'RecipeBookDisease'),
			array('purposeIds', 'safe'),
			array('source_type', 'in', 'range' => array('me', 'internet', 'book')),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, disease_id, user_id, text, source_type, internet_link, internet_favicon, internet_title, book_author, book_name, create_time, views_amount', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'ingredients' => array(self::HAS_MANY, 'RecipeBookIngredient', 'recipe_id'),
            'disease' => array(self::BELONGS_TO, 'RecipeBookDisease', 'disease_id'),
            'purposes' => array(self::MANY_MANY, 'RecipeBookPurpose', 'recipeBook_recipe_via_purpose(recipe_id, purpose_id)'),
            'commentsCount' => array(self::STAT, 'Comment', 'object_id', 'condition' => 'model=:modelName', 'params' => array(':modelName' => 'RecipeBookRecipe')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Заголовок рецепта',
			'disease_id' => 'Болезнь',
			'user_id' => 'User',
			'text' => 'Текст рецепта',
			'source_type' => 'Source Type',
			'internet_link' => 'Internet Link',
			'internet_favicon' => 'Internet Favicon',
			'internet_title' => 'Internet Title',
			'book_author' => 'Book Author',
			'book_name' => 'Book Name',
			'create_time' => 'Create Time',
			'views_amount' => 'Views Amount',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('disease_id',$this->disease_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('source_type',$this->source_type,true);
		$criteria->compare('internet_link',$this->internet_link,true);
		$criteria->compare('internet_favicon',$this->internet_favicon,true);
		$criteria->compare('internet_title',$this->internet_title,true);
		$criteria->compare('book_author',$this->book_author,true);
		$criteria->compare('book_name',$this->book_name,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('views_amount',$this->views_amount);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getProPercent()
    {
        return $this->totalVotes == 0 ? 0 : round(($this->votes_pro / $this->totalVotes) * 100, 2);
    }

    public function getConPercent()
    {
        return $this->totalVotes == 0 ? 0 : round(($this->votes_con / $this->totalVotes) * 100, 2);
    }

    public function getTotalVotes()
    {
        return $this->votes_pro + $this->votes_con;
    }

    public function vote($user_id, $vote)
    {
        $current_vote = $this->getCurrentVote($user_id);

        if ($current_vote === NULL)
        {
            Yii::app()->db->createCommand()
                ->insert('recipeBook_recipe_vote', array(
                'recipe_id' => $this->id,
                'user_id' => $user_id,
                'vote' => $vote,
            ));

            Yii::app()->db->createCommand()
                ->update($this->tableName(), array($this->columnByVote($vote) => new CDbExpression($this->columnByVote($vote) . ' + 1')), 'id = :recipe_id', array(':recipe_id' => $this->id));
        }
        elseif ($current_vote != $vote)
        {
            Yii::app()->db->createCommand()
                ->update('recipeBook_recipe_vote', array('vote' => $vote), 'user_id = :user_id AND recipe_id = :recipe_id', array(
                ':user_id' => $user_id,
                ':recipe_id' => $this->id,
            ));

            Yii::app()->db->createCommand()
                ->update($this->tableName(), array($this->columnByVote($vote) => new CDbExpression($this->columnByVote($vote) . ' + 1')), 'id = :recipe_id', array(':recipe_id' => $this->id));

            Yii::app()->db->createCommand()
                ->update($this->tableName(), array($this->columnByVote($current_vote) => new CDbExpression($this->columnByVote($vote) . ' - 1')), 'id = :recipe_id', array(':recipe_id' => $this->id));
        }
    }

    protected function columnByVote($vote)
    {
        $array = array(
            '0' => 'votes_con',
            '1' => 'votes_pro',
        );

        return $array[$vote];
    }

    public function getCurrentVote($user_id)
    {
        $vote = Yii::app()->db->createCommand()
            ->select('vote')
            ->from('recipeBook_recipe_vote')
            ->where('recipe_id = :recipe_id AND user_id = :user_id', array(':recipe_id' => $this->id, ':user_id' => $user_id))
            ->queryScalar();

        return ($vote === FALSE) ? null : $vote;
    }
}