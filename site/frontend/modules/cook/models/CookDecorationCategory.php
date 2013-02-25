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

    public function getPhotoCollectionIds()
    {
        $command = Yii::app()->db->createCommand();
        $command
            ->select('id, photo_id')
            ->from('cook__decorations')
            ->order('id DESC')
        ;

        if (! empty($this->id))
            $command->where('category_id = :category_id' , array(':category_id' => $this->id));

        return $command->queryAll();
    }

    public function getPhotoCollectionCount()
    {
        $command = Yii::app()->db->createCommand();
        $command
            ->select('count(*) as c')
            ->from('cook__decorations')
            ->order('id DESC')
        ;

        if (! empty($this->id))
            $command->where('category_id = :category_id' , array(':category_id' => $this->id));

        return $command->queryScalar();
    }


    public function getNearestIds($photo_id, $num = 50)
    {
        $ids = array();

        $items = $this->getPhotoCollectionIds();
        $count = count($items);

        foreach ($items as $k => $i) {
            if ($i['photo_id'] == $photo_id) {
                $currentIndex = $k;
                $ids[$currentIndex] = $i['id'];
                break;
            }
        }

        $currentNext = $currentIndex;
        $currentPrev = $currentIndex;
        for ($i = 0; $i < $num; $i++) {
            $currentNext = ($currentNext == ($count - 1)) ? 0 : ($currentNext + 1);
            $currentPrev = ($currentPrev == 0) ? ($count - 1) : ($currentPrev - 1);
            $ids[$currentNext] = $items[$currentNext]['id'];
            $ids[$currentPrev] = $items[$currentPrev]['id'];
        }

        return $ids;
    }

    public function getIndex($photo_id)
    {
        $items = $this->getPhotoCollectionIds();

        foreach ($items as $k => $i) {
            if ($i['photo_id'] == $photo_id)
                return $k;
        }
    }

    public function getPhotoCollection($photo_id = null)
    {
        $criteria = new CDbCriteria(array(
            'with' => array(
                'photo' => array(
                    'with' => array(
                        'author' => array(
                            'select' => 'id, gender, first_name, last_name, online, avatar_id, deleted',
                            'with' => 'avatar',
                        ),
                    ),
                ),
            ),
            'limit' => 300,
        ));

        if ($photo_id !== null && Yii::app()->controller->action->id != 'postLoad') {
            $nearest = $this->getNearestIds($photo_id);
            $criteria->compare('t.id', $nearest);
        }

        if ($this->id !== null)
            $criteria->compare('category_id', $this->id);

        $decorations = CookDecoration::model()->findAll($criteria);

        $photos = array();
        foreach($decorations as $model)
        {
            $model->photo->w_title = $model->title;
            $model->photo->w_description = $model->description;
            if ($photo_id !== null && Yii::app()->controller->action->id != 'postLoad')
                $model->photo->w_idx = array_search($model->id, $nearest);
            $photos[] = $model->photo;
        }

        $collection = array(
            'title' => (empty($this->id)) ?
                'Фотоальбом к сервису ' . CHtml::link('Офомление блюд', array('cook/decor/index'))
                :
                'Фотоальбом ' . CHtml::link($this->title, array('cook/decor/index', 'id' => $this->id)) . ' к сервису ' . CHtml::link('Офомление блюд', array('cook/decor/index'))
            ,
            'photos' => $photos,
        );

        return $collection;
    }

    public function getUrl()
    {
        return Yii::app()->createUrl('/cook/decor/index', array('id' => $this->id));
    }
}