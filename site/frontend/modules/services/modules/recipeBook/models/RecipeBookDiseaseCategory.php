<?php

/**
 * This is the model class for table "recipe_book__disease_categories".
 *
 * The followings are the available columns in table 'recipe_book__disease_categories':
 * @property string $id
 * @property string $title
 * @property string $slug
 * @property string $title_all
 * @property string $description
 * @property string $description_center
 * @property string $description_extra
 * @property string $photo_id
 *
 * The followings are the available model relations:
 * @property RecipeBookDisease[] $diseases
 * @property AlbumPhoto $photo
 */
class RecipeBookDiseaseCategory extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RecipeBookDiseaseCategory the static model class
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
		return 'recipe_book__disease_categories';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('slug', 'site.frontend.extensions.translit.ETranslitFilter', 'translitAttribute' => 'title'),
            array('title, slug', 'required'),
			array('title, slug, title_all', 'length', 'max'=>255),
			array('photo_id', 'length', 'max'=>11),
			array('description, description_center, description_extra', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, slug, title_all, description, description_center, description_extra, photo_id', 'safe', 'on'=>'search'),
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
			'diseases' => array(self::HAS_MANY, 'RecipeBookDisease', 'category_id'),
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
			'slug' => 'Slug',
			'title_all' => 'Заголоков для "Все болезни..."',
			'description' => 'Описание',
			'description_center' => 'Описание 2',
			'description_extra' => 'Описание 3',
			'photo_id' => 'Фото',
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
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('title_all',$this->title_all,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('description_center',$this->description_center,true);
		$criteria->compare('description_extra',$this->description_extra,true);
		$criteria->compare('photo_id',$this->photo_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getImage()
    {
        if (!empty($this->photo_id))
            return CHtml::image($this->photo->getPreviewUrl(70, 70));
        return '';
    }

    public function scopes()
    {
        $alias = $this->getTableAlias();
        return array(
            'alphabetical' => array(
                'order' => $alias . '.title ASC',
            ),
        );
    }

    public function getUrl()
    {
        return Yii::app()->createUrl('/services/recipeBook/default/category', array('slug' => $this->slug));
    }
}