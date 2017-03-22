<?php

namespace site\frontend\modules\iframe\models;

/**
 * This is the model class for table "qa__categories".
 *
 * The followings are the available columns in table 'qa__categories':
 * @property int $id
 * @property string $title
 *
 * The followings are the available model relations:
 * @property \site\frontend\modules\iframe\models\QaQuestion[] $questions
 * @property int $questionsCount
 * @property \site\frontend\modules\iframe\models\QaTag[] $tags
 */
class QaCategory extends \HActiveRecord
{

    /**
     * ID категории "Мой педиатр"
     *
     * @var integer
     */
    const PEDIATRICIAN_ID = 124;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'qa__categories';
	}

	/**
	 * @return array
	 */
	public function getTagTitles()
	{
	    $titles = [];

	    foreach ($this->tags as $objTag)
	    {
            $titles[$objTag->id] = $objTag->getTitle();
	    }

	    asort($titles);

	    return $titles;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

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
			'questions' => array(self::HAS_MANY, 'site\frontend\modules\iframe\models\QaQuestion', 'categoryId'),
			'questionsCount' => array(self::STAT, 'site\frontend\modules\iframe\models\QaQuestion', 'categoryId'),
			'tags' => array(self::HAS_MANY, get_class(QaTag::model()), 'category_id'),
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
			'consultationId' => 'Consultation',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return QaCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function sorted()
	{
		$this->getDbCriteria()->order = 'sort ASC';
		return $this;
	}

	public function byTitle($title)
	{
		$this->getDbCriteria()->compare('title', $title);
		return $this;
	}

	/**
	 * Проверка на категорию "Мой педиатр"
	 *
	 * @return boolean
	 */
	public function isPediatrician()
	{
	   return isset($this->id) ? $this->id == self::PEDIATRICIAN_ID : FALSE;
	}
}
