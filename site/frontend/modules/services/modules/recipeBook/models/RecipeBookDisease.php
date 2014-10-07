<?php

/**
 * This is the model class for table "recipeBook_disease".
 *
 * The followings are the available columns in table 'recipeBook_disease':
 * @property string $id
 * @property string $title
 * @property string $category_id
 * @property integer $with_recipies
 * @property string $text
 * @property string $reasons_name
 * @property string $symptoms_name
 * @property string $treatment_name
 * @property string $prophylaxis_name
 * @property string diagnosis_name
 * @property string $reasons_text
 * @property string $symptoms_text
 * @property string $treatment_text
 * @property string $prophylaxis_text
 * @property string diagnosis_text
 * @property string $slug
 *
 * The followings are the available model relations:
 * @property RecipeBookDiseaseCategory $category
 * @property RecipeBookRecipe[] $recipeBookRecipes
 * @property AlbumPhoto $photo
 */
class RecipeBookDisease extends HActiveRecord implements IPreview
{
    /**
     * Returns the static model of the specified AR class.
     * @return RecipeBookDisease the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'recipe_book__diseases';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, slug, category_id, with_recipies, text, reasons_text, symptoms_text, diagnosis_text, treatment_text, prophylaxis_text', 'required'),
            array('with_recipies', 'boolean'),
            array('title, slug, reasons_name, symptoms_name, diagnosis_name, treatment_name, prophylaxis_name', 'length', 'max' => 255),
            array('category_id', 'exist', 'attributeName' => 'id', 'className' => 'RecipeBookDiseaseCategory'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, slug, category_id, with_recipies, text, reasons_name, symptoms_name, diagnosis_name, treatment_name, prophylaxis_name, reasons_text, symptoms_text, treatment_text, prophylaxis_text', 'safe', 'on' => 'search'),
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
            'category' => array(self::BELONGS_TO, 'RecipeBookDiseaseCategory', 'category_id'),
            'recipes' => array(self::HAS_MANY, 'RecipeBookRecipe', 'disease_id'),
            'recipesCount' => array(self::STAT, 'RecipeBookRecipe', 'disease_id'),
            'photo' => array(self::BELONGS_TO, 'AlbumPhoto', 'photo_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Название',
            'slug' => 'Для урла',
            'category_id' => 'Раздел',
            'with_recipies' => 'Можно добавлять рецепты',
            'text' => 'Текст',
            'reasons_name' => 'Заголовок "Причины"',
            'symptoms_name' => 'Заголовок "Симптомы"',
            'diagnosis_name' => 'Заголовок "Диагностика"',
            'treatment_name' => 'Заголовок "Лечение"',
            'prophylaxis_name' => 'Заголовок "Профилактика"',
            'reasons_text' => 'Текст "Причины"',
            'symptoms_text' => 'Текст "Симптомы"',
            'diagnosis_text' => 'Текст "Диагностика"',
            'treatment_text' => 'Текст "Лечение"',
            'prophylaxis_text' => 'Текст "Профилактика"',
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
        $criteria->compare('title', $this->title, true);
        $criteria->compare('category_id', $this->category_id, true);
        $criteria->compare('with_recipies', $this->with_recipies);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('reasons_name', $this->reasons_name, true);
        $criteria->compare('symptoms_name', $this->symptoms_name, true);
        $criteria->compare('treatment_name', $this->treatment_name, true);
        $criteria->compare('prophylaxis_name', $this->prophylaxis_name, true);
        $criteria->compare('reasons_text', $this->reasons_text, true);
        $criteria->compare('symptoms_text', $this->symptoms_text, true);
        $criteria->compare('treatment_text', $this->treatment_text, true);
        $criteria->compare('prophylaxis_text', $this->prophylaxis_text, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function GetDiseaseAlphabetList($diseases)
    {
        $result = array();
        foreach ($diseases as $disease) {
            $first_letter = mb_substr($disease->title, 0, 1, 'UTF-8');
            if (isset($result[$first_letter]))
                $result[$first_letter][] = $disease;
            else
                $result[$first_letter] = array($disease);
        }

        return $result;
    }

    public static function GetDiseaseCategoryList($diseases)
    {
        $result = array();
        foreach ($diseases as $disease) {
            $cat = $disease->category->title;
            if (isset($result[$cat]))
                $result[$cat][] = $disease;
            else
                $result[$cat] = array($disease);
        }

        return $result;
    }

    public function getShort()
    {
        return trim($this->text);
    }

    public function getImage()
    {
        preg_match('!<img.*?src="(.*?)"!', $this->text, $matches);
        if (count($matches) > 0)
            return $matches[1];
        return false;
    }

    public function getAdminImage()
    {
        if (!empty($this->photo_id))
            return CHtml::image($this->photo->getPreviewUrl(70, 70));
        return '';
    }

    public function getUrl()
    {
        return Yii::app()->createUrl('/services/recipeBook/default/disease', array('slug' => $this->slug));
    }

    public function getPreviewPhoto()
    {
        return $this->getImage();
    }

    public function getPreviewText()
    {
        return $this->getShort();
    }
}