<?php

namespace site\frontend\modules\specialists\models;
use site\frontend\modules\specialists\components\SpecialistsManager;
use site\frontend\modules\specialists\models\sub\Career;

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

    public $firstName;
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
            ['firstName, lastName, placeOfWork, specializations, text', 'safe'],

            ['category', 'in', 'range' => array_keys(SpecialistProfile::$categoriesList)],
            ['experience', 'in', 'range' => array_keys(SpecialistProfile::$experienceList)],

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

        $this->firstName = $this->user->first_name;
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
        $this->user->first_name = $this->firstName;
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

            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'experience' => $this->experience,
            'placeOfWork' => $this->placeOfWork,
            'category' => $this->category,
            'text' => $this->text,

            'career' => $this->career,
            'education' => $this->education,
            'courses' => $this->courses,

            'specializationsList' => $this->getSpecializationsList(),
            'specializations' => $this->specializations,

            'categoriesList' => SpecialistProfile::$categoriesList,
            'experienceList' => SpecialistProfile::$experienceList,
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
        return SpecialistSpecialization::model()->findAll([
            'condition' => 'groupId = :groupId',
            'params' => [':groupId' => SpecialistGroup::PEDIATRICIAN],
        ]);
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