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
		    array('title, disease_id, author_id, text, ingredients', 'required'),
            array('title', 'length', 'max' => 255),
            array('disease_id', 'exist', 'attributeName' => 'id', 'className' => 'RecipeBookDisease'),
            array('author_id', 'exist', 'attributeName' => 'id', 'className' => 'User'),
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
			'title' => 'Название народного рецепта',
			'updated' => 'Updated',
			'created' => 'Created',
			'disease_id' => 'Выберите болезнь',
			'author_id' => 'Author',
			'text' => 'Описание приготовления',

            'ingredients' => 'Ингредиенты',
            'category_id' => 'Выберите тип заболеваний',
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

    public function behaviors()
    {
        return array(
            'withRelated' => array(
                'class' => 'site.common.extensions.wr.WithRelatedBehavior',
            ),
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
            ),
            'processingImages' => array(
                'class' => 'site.common.behaviors.ProcessingImagesBehavior',
                'attributes' => array('text'),
            ),
        );
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

    protected function beforeSave()
    {
        if (! $this->isNewRecord) {
            RecipeBookRecipeIngredient::model()->deleteAll('recipe_id = :recipe_id', array(':recipe_id' => $this->id));
        }

        return parent::beforeSave();
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

    public function disease($diseaseId)
    {
        $alias = $this->getTableAlias();
        $this->getDbCriteria()->compare($alias . '.disease_id', $diseaseId);
        return $this;
    }

    public static function getDp($diseaseId)
    {
        $criteria = new CDbCriteria(array(
            'order' => 't.created DESC',
        ));
        if ($diseaseId !== null) {
            $criteria->scopes = array(
                'disease' => $diseaseId,
            );
        }

        return new CActiveDataProvider(__CLASS__, array(
            'criteria' => $criteria,
        ));
    }
}