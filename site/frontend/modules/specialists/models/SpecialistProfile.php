<?php

namespace site\frontend\modules\specialists\models;
use site\frontend\modules\specialists\models\sub\MultipleRowsModel;

/**
 * This is the model class for table "specialists__profiles".
 *
 * The followings are the available columns in table 'specialists__profiles':
 * @property string $id
 * @property string $specialization
 * @property string $courses
 * @property string $education
 * @property string $career
 * @property string $experience
 * @property string $category
 * @property string $placeOfWork
 *
 * The followings are the available model relations:
 * @property \site\frontend\modules\users\models\User $user
 * @property SpecialistSpecialization[] $specializations
 */
class SpecialistProfile extends \CActiveRecord
{
    protected $_relatedModels = [];

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'specialists__profiles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('career', 'filter', 'filter' => array($this->careerObject, 'serialize')),
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
			'user' => array(self::BELONGS_TO, 'site\frontend\modules\users\models\User', 'id'),
			'specializations' => array(self::MANY_MANY, 'site\frontend\modules\specialists\models\SpecialistSpecialization', 'specialists__profiles_specializations(profileId, specializationId)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'specialization' => 'Specialization',
			'courses' => 'Courses',
			'education' => 'Education',
			'career' => 'Career',
			'experience' => 'Experience',
			'category' => 'Category',
			'placeOfWork' => 'Place Of Work',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return \CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new \CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('specialization',$this->specialization,true);
		$criteria->compare('courses',$this->courses,true);
		$criteria->compare('education',$this->education,true);
		$criteria->compare('career',$this->career,true);
		$criteria->compare('experience',$this->experience,true);
		$criteria->compare('category',$this->category,true);
		$criteria->compare('placeOfWork',$this->placeOfWork,true);

		return new \CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SpecialistProfile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getCareerObject()
    {
        if (!isset($this->_relatedModels['career']))
            $this->_relatedModels['career'] = new MultipleRowsModel($this->career, $this, 'site\frontend\modules\specialists\models\sub\Career');

        return $this->_relatedModels['career'];
    }

    public function getEducationObject()
    {
        if (!isset($this->_relatedModels['education']))
            $this->_relatedModels['education'] = new MultipleRowsModel($this->career, $this, 'site\frontend\modules\specialists\models\sub\Education');

        return $this->_relatedModels['education'];
    }

    public function getCoursesObject()
    {
        if (!isset($this->_relatedModels['courses']))
            $this->_relatedModels['courses'] = new MultipleRowsModel($this->career, $this, 'site\frontend\modules\specialists\models\sub\Courses');

        return $this->_relatedModels['courses'];
    }
}
