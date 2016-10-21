<?php

namespace site\frontend\modules\specialists\models;
use site\frontend\modules\specialists\components\SpecialistsManager;
use site\frontend\modules\specialists\models\sub\Career;
use site\frontend\modules\users\models\User;

/**
 * @property \CModel[] $career
 * @property \CModel[] $education
 * @property \CModel[] $courses
 * @property \User $user
 * @property SpecialistProfile $profile
 */
class ProfileForm extends \CFormModel implements \IHToJSON
{
    public $profileId;

    public $gender;
    public $firstName;
    public $middleName;
    public $lastName;
    public $experience;
    public $category;
    public $placeOfWork;
    public $text;

    public $specializations;

    private $_career = [];
    private $_education = [];
    private $_courses = [];

    private $_profile;
    private $_user;

    public function rules()
    {
        return [
            ['placeOfWork, specializations, text', 'safe'],

            ['firstName, lastName, middleName, gender', 'required'],
            ['firstName, lastName, middleName', 'length', 'max' => 50],
            ['category', 'in', 'range' => array_keys(SpecialistProfile::getCategoriesList())],
            ['experience', 'in', 'range' => array_keys(SpecialistProfile::getExperienceList())],
            ['gender', 'in', 'range' => [User::GENDER_MALE, User::GENDER_FEMALE]],

            ['career', 'validateRelatedModels'],
            ['education', 'validateRelatedModels'],
            ['courses', 'validateRelatedModels'],
        ];
    }

    public function validateRelatedModels($attribute, $params)
    {
        /** @var \CModel[] $models */
        $models = $this->$attribute;
        $isValid = true;
        $errors = [];
        foreach ($models as $model) {
            if (! $model->validate()) {
                $isValid = false;
            }
            $errors[] = $model->errors;
        }
        if (! $isValid) {
            $this->addError($attribute, $errors);
        }
    }

    public function attributeLabels()
    {
        return [
            'firstName' => 'Имя',
            'lastName' => 'Фамилия',
            'experience' => 'Стаж',
            'category' => 'Категория',
            'placeOfWork' => 'Место работы',
        ];
    }

    public function initialize($profileId)
    {
        $this->profileId = $profileId;

        $this->gender = $this->user->gender;
        $this->firstName = $this->user->first_name;
        $this->middleName = $this->user->middle_name;
        $this->lastName = $this->user->last_name;
        $this->experience = $this->profile->experience;
        $this->category = $this->profile->category;
        $this->placeOfWork = $this->profile->placeOfWork;
        $this->text = $this->profile->specialization;

        $this->specializations = $this->getSpecializations();

        $this->career = $this->profile->careerObject->models;
        $this->education = $this->profile->educationObject->models;
        $this->courses = $this->profile->coursesObject->models;
    }

    public function save()
    {
        $this->user->gender = $this->gender;
        $this->user->first_name = $this->firstName;
        $this->user->middle_name = $this->middleName;
        $this->user->last_name = $this->lastName;
        $this->profile->experience = $this->experience;
        $this->profile->category = $this->category;
        $this->profile->placeOfWork = $this->placeOfWork;
        $this->profile->specialization = $this->text;

        SpecialistsManager::assignSpecializations($this->specializations, $this->profileId, true);

        $this->profile->careerObject->models = $this->career;
        $this->profile->educationObject->models = $this->education;
        $this->profile->coursesObject->models = $this->courses;

        return $this->user->save() && $this->profile->save();
    }

    public function toJSON()
    {
        return [
            'profileId' => $this->profileId,

            'gender' => $this->gender,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'middleName' => $this->middleName,
            'experience' => $this->experience,
            'placeOfWork' => $this->placeOfWork,
            'category' => $this->category,
            'text' => $this->text,

            'career' => $this->career,
            'education' => $this->education,
            'courses' => $this->courses,

            'specializationsList' => $this->getSpecializationsList(),
            'specializations' => $this->specializations,

            'categoriesList' => SpecialistProfile::getCategoriesList(),
            'experienceList' => SpecialistProfile::getExperienceList(),
        ];
    }

    public function setCareer(array $data)
    {
        $this->_career = $this->createModels($data, 'site\frontend\modules\specialists\models\sub\Career');
    }

    public function getCareer()
    {
        return $this->_career;
    }

    public function setEducation(array $data)
    {
        $this->_education = $this->createModels($data, 'site\frontend\modules\specialists\models\sub\Education');
    }

    public function getEducation()
    {
        return $this->_education;
    }

    public function setCourses(array $data)
    {
        $this->_courses = $this->createModels($data, 'site\frontend\modules\specialists\models\sub\Courses');
    }

    public function getCourses()
    {
        return $this->_courses;
    }

    public function getUser()
    {
        if (! $this->_user) {
            $this->_user = \User::model()->findByPk($this->profileId);
        }
        return $this->_user;
    }

    public function getProfile()
    {
        if (! $this->_profile) {
            $this->_profile = SpecialistProfile::model()->findByPk($this->profileId);
        }
        return $this->_profile;
    }

    protected function getSpecializations()
    {
        $profile = SpecialistProfile::model()->findByPk($this->profileId);
        return array_map(function($spec) {
            return $spec->id;
        }, $profile->specializations);
    }

    protected function getSpecializationsList()
    {
        return SpecialistsManager::getSpecializations(SpecialistGroup::DOCTORS);
    }

    protected function createModels(array $data, $modelName)
    {
        return  array_map(function($row) use ($modelName) {
            if (is_array($row)) {
                $model = new $modelName;
                $model->setAttributes($row);
            } else {
                $model = $row;
            }
            return $model;
        }, $data);
    }
}