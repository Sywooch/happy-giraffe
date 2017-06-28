<?php

namespace site\frontend\modules\specialists\models;
use site\frontend\modules\som\modules\qa\models\QaCategory;
use site\frontend\modules\specialists\models\sub\MultipleRowsModel;
use site\frontend\modules\specialists\components\SpecialistsManager;
use site\frontend\modules\specialists\models\specialistsAuthorizationTasks\AuthorizationTypeEnum;
use site\frontend\modules\specialists\models\specialistProfile\AuthorizationEnum;
use site\frontend\modules\som\modules\qa\models\QaCTAnswer;

/**
 * This is the model class for table "specialists__profiles".
 *
 * The followings are the available columns in table 'specialists__profiles':
 * @property string $id
 * @property string $specialization
 * @property string $courses
 * @property string $experience
 * @property string $category
 * @property string $placeOfWork
 * @property string $greeting
 * @property integer $authorization_status
 *
 * The followings are the available model relations:
 * @property \site\frontend\modules\users\models\User $user
 * @property SpecialistSpecialization[] $specializations
 * @property SpecialistsCareer[] $career
 * @property SpecialistsEducation[] $educationTest
 * @property \site\frontend\modules\specialists\models\SpecialistChatsStatistic $chat_statistics
 */
class SpecialistProfile extends \HActiveRecord
{
	public static function getCategoriesList()
	{
		return [
			'first' => 'Первая категория',
			'second' => 'Вторая категория',
			'top' => 'Высшая категория',
		];
	}

	public static function getExperienceList()
	{
		return array_merge(array_combine(range(1, 20), array_map(function($n) {
			return $n . ' ' . \Str::GenerateNoun(['год', 'года', 'лет'], $n);
		}, range(1, 20))), [
			'20+' => 'Более 20 лет',
		]);
	}

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
			array('courses', 'filter', 'filter' => array($this->coursesObject, 'serialize')),
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
			'chat_statistics' => array(self::HAS_ONE, 'site\frontend\modules\specialists\models\SpecialistChatsStatistic', 'user_id'),
			'specializations' => array(self::MANY_MANY, 'site\frontend\modules\specialists\models\SpecialistSpecialization', 'specialists__profiles_specializations(profileId, specializationId)', 'scopes' => ['sorted']),
            'career' => [self::HAS_MANY, SpecialistsCareer::class, 'profile_id'],
            'educationTest' => [self::HAS_MANY, SpecialistsEducation::class, 'profile_id'],
			'rating' => [self::HAS_ONE, 'site\frontend\modules\som\modules\qa\models\QaRating', 'user_id',
				'on'        => 'rating.category_id = :category_id',
				'params'    => [':category_id' => QaCategory::PEDIATRICIAN_ID]
            ],
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

	/**
	 * @return boolean
	 */
	public function authorizationIsDone()
	{
	    return $this->authorization_status == AuthorizationEnum::ACTIVE;
	}

	/**
	 * @return boolean
	 */
	public function setAuthorizationStatusActive()
	{
	    $this->authorization_status = AuthorizationEnum::ACTIVE;

	    return $this->save();
	}

	/**
	 * @return boolean
	 */
	public function setAuthorizationStatusNotActive()
	{
	    $this->authorization_status = AuthorizationEnum::NOT_ACTIVE;

	    return $this->save();
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
            $this->_relatedModels['education'] = new MultipleRowsModel($this->education, $this, 'site\frontend\modules\specialists\models\sub\Education');

        return $this->_relatedModels['education'];
    }

    public function getCoursesObject()
    {
        if (!isset($this->_relatedModels['courses']))
            $this->_relatedModels['courses'] = new MultipleRowsModel($this->courses, $this, 'site\frontend\modules\specialists\models\sub\Courses');

        return $this->_relatedModels['courses'];
    }

	public function getSpecsString()
	{
		return $this->specializations ? implode(', ', array_map(function($spec) {
			return $spec->title;
		}, $this->specializations)) : '';
	}

	/**
	 * @return SpecialistProfile
	 */
	public function isOnline()
	{
		if (!isset($this->getDbCriteria()->with['user'])) {
			$this->getDbCriteria()->with[] = 'user';
		}

		$this->getDbCriteria()->compare('user.online', 1);

		return $this;
	}

	/**
	 * @return SpecialistProfile
	 */
	public function isOffline()
	{
		if (!isset($this->getDbCriteria()->with['user'])) {
			$this->getDbCriteria()->with[] = 'user';
		}

		$this->getDbCriteria()->compare('user.online', 0);

		return $this;
	}

	/**
	 * @return SpecialistProfile
	 */
	public function inChat()
	{
		if (!isset($this->getDbCriteria()->with['user'])) {
			$this->getDbCriteria()->with[] = 'user';
		}

		$this->getDbCriteria()->compare('user.is_in_chat', 1);

		return $this;
	}

	/**
	 * @return SpecialistProfile
	 */
	public function authorized()
	{
		$this->getDbCriteria()->compare('authorization_status', AuthorizationEnum::ACTIVE);

		return $this;
	}

	/**
	 * @return SpecialistProfile
	 */
	public function notAuthorized()
	{
		$this->getDbCriteria()->compare('authorization_status', AuthorizationEnum::NOT_ACTIVE);

		return $this;
	}

	/**
	 * @return SpecialistProfile
	 */
	public function hasRating()
	{
		if (!isset($this->getDbCriteria()->with['rating'])) {
			$this->getDbCriteria()->with[] = 'rating';
		}

		$this->getDbCriteria()->compare('rating.total_count', '> 0');

		return $this;
	}
}
