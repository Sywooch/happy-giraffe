<?php

/**
 * This is the model class for table "cook__decorations__categories".
 *
 * The followings are the available columns in table 'cook__decorations__categories':
 * @property string $id
 * @property string $title
 *
 * The followings are the available model relations:
 * @property CookDecoration[] $decorations
 */
class CookDecorationCategory extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CookDecorationCategory the static model class
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
		return 'cook__decorations__categories';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, title_h1', 'required'),
			array('title, title_h1', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, title_h1', 'safe', 'on'=>'search'),
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
			'decorations' => array(self::HAS_MANY, 'CookDecoration', 'category_id'),
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
            'title_h1'=> 'title h1'
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
        $criteria->compare('title_h1',$this->title_h1,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getPhotoCollection()
    {
        $cacheId = ($this->id) ? 'wPhoto_decor_' . $this->id : 'wPhoto_decor_all';
        $sql = "SELECT * FROM " . CookDecoration::model()->tableName();
        if ($this->id)
            $sql .= " WHERE id = " . $this->id;

        $collection = Yii::app()->cache->get($cacheId);

        if ($collection === false) {
            if (empty($this->id))
                $decorations = CookDecoration::model()->findAll();
            else
                $decorations = $this->decorations;

            $photos = array();
            foreach($decorations as $model)
            {
                $model->photo->w_title = $model->title;
                $model->photo->w_description = $model->description;
                array_push($photos, $model->photo);
            }
            $collection = array(
                'title' => (empty($this->id)) ?
                    'Фотоальбом к сервису ' . CHtml::link('Офомление блюд', array('cook/decor/index'))
                    :
                    'Фотоальбом ' . CHtml::link($this->title, array('cook/decor/index', 'id' => $this->id)) . ' к сервису ' . CHtml::link('Офомление блюд', array('cook/decor/index'))
                ,
                'photos' => $photos,
            );

            Yii::app()->cache->set($cacheId, $collection, 0, new CDbCacheDependency($sql));
        }
        return $collection;
    }
}