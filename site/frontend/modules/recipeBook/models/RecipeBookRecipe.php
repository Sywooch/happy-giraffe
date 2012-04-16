<?php

/**
 * This is the model class for table "recipeBook_recipe".
 *
 * The followings are the available columns in table 'recipeBook_recipe':
 * @property string $id
 * @property string $name
 * @property string $disease_id
 * @property string $author_id
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
 * @property User $author
 */
class RecipeBookRecipe extends CActiveRecord
{
    private $_purposeIds = null;
    public $vote;

    public function getPurposeIds()
    {
        if ($this->_purposeIds === null) {
            $this->_purposeIds = array();
            if (!$this->isNewRecord) {
                foreach ($this->purposes as $purpose)
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
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function behaviors()
    {
        return array(
            'CAdvancedArBehavior' => array('class' => 'site.frontend.extensions.CAdvancedArBehavior'),
            'VoteBehavior' => array(
                'class' => 'VoteBehavior',
                'vote_attributes' => array(
                    '0' => 'votes_con',
                    '1' => 'votes_pro',
                )),
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
            ),
        );
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
            array('name, disease_id, purposeIds, text', 'required'),
            array('views_amount', 'numerical', 'integerOnly' => true),
            array('name, internet_link, internet_favicon, internet_title, book_author, book_name', 'length', 'max' => 255),
            array('disease_id', 'exist', 'attributeName' => 'id', 'className' => 'RecipeBookDisease'),
            array('author_id', 'exist', 'attributeName' => 'id', 'className' => 'User'),
            array('purposeIds', 'safe'),
            array('source_type', 'in', 'range' => array('me', 'internet', 'book')),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, disease_id, author_id, text, source_type, internet_link, internet_favicon, internet_title, book_author, book_name, views_amount', 'safe', 'on' => 'search'),
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
            'ingredients' => array(self::HAS_MANY, 'RecipeBookIngredient', 'recipe_id'),
            'disease' => array(self::BELONGS_TO, 'RecipeBookDisease', 'disease_id'),
            'purposes' => array(self::MANY_MANY, 'RecipeBookPurpose', 'recipe_book__recipes_purposes(recipe_id, purpose_id)'),
            'commentsCount' => array(self::STAT, 'Comment', 'entity_id', 'condition' => 'entity=:modelName', 'params' => array(':modelName' => 'RecipeBookRecipe')),
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
            'author_id' => 'Автор',
            'text' => 'Текст рецепта',
            'source_type' => 'Source Type',
            'internet_link' => 'Internet Link',
            'internet_favicon' => 'Internet Favicon',
            'internet_title' => 'Internet Title',
            'book_author' => 'Book Author',
            'book_name' => 'Book Name',
            'create_time' => 'Create Time',
            'views_amount' => 'Views Amount',
            'purposeIds' => 'Назначение рецепта',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('disease_id', $this->disease_id, true);
        $criteria->compare('author_id', $this->author_id, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('source_type', $this->source_type, true);
        $criteria->compare('internet_link', $this->internet_link, true);
        $criteria->compare('internet_favicon', $this->internet_favicon, true);
        $criteria->compare('internet_title', $this->internet_title, true);
        $criteria->compare('book_author', $this->book_author, true);
        $criteria->compare('book_name', $this->book_name, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('views_amount', $this->views_amount);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function defaultScope()
    {
        return array(
            'order' => $this->getTableAlias(false, false).'.id desc',
        );
    }

    public function afterSave()
    {
        parent::afterSave();

        if ($this->isNewRecord) {
            UserScores::addScores($this->author_id, ScoreActions::ACTION_RECORD, 1, $this);
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();
        UserScores::removeScores($this->author_id, ScoreActions::ACTION_RECORD, 1, $this);
    }

    public function getUrl()
    {
        return Yii::app()->createUrl('recipeBook/default/view', array('id' => $this->id));
    }
}