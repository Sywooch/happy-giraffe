<?php

namespace site\frontend\modules\specialists\models;
use site\frontend\modules\specialists\components\SpecialistsManager;
use site\frontend\modules\specialists\models\sub\Career;

/**
 * @property \CModel[] $career
 * @property \CModel[] $education
 * @property \CModel[] $courses
 */
class ProfileForm extends \CFormModel implements \IHToJSON
{
    public $profileId;

    public $firstName;
    public $lastName;

    public $experience;
    public $category;
    public $placeOfWork;
    
    public $specializations;
    public $spec1;
    public $spec2;

    private $_career = [];
    private $_education = [];
    private $_courses = [];

    public function rules()
    {
        return [
            ['firstName, lastName, category, experience, placeOfWork, spec1, spec2', 'safe'],

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
    
    public function save()
    {
        $profile = SpecialistProfile::model()->findByPk($this->profileId);
        $user = \User::model()->findByPk($this->profileId);
        
        foreach (['experience', 'category', 'placeOfWork'] as $attr) {
            $profile->$attr = $this->$attr;
        }

        $user->first_name = $this->firstName;
        $user->last_name = $this->lastName;

        $profile->experience = $this->experience;
        $profile->category = $this->category;
        $profile->placeOfWork = $this->placeOfWork;
        
        $profile->careerObject->models = $this->career;
        $profile->educationObject->models = $this->education;
        $profile->coursesObject->models = $this->courses;
        SpecialistsManager::assignSpecializations(array_filter([$this->spec1, $this->spec2]), $this->profileId, true);
        return $user->save() && $profile->save();
    }

    public function initialize($profileId)
    {
        $profile = SpecialistProfile::model()->findByPk($profileId);
        $user = \User::model()->findByPk($profileId);
        $this->profileId = $profileId;

        $this->firstName = $user->first_name;
        $this->lastName = $user->last_name;
        
        $this->experience = $profile->experience;
        $this->category = $profile->category;
        $this->placeOfWork = $profile->placeOfWork;

        $this->career = $profile->careerObject->models;
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

            'career' => $this->career,
            'education' => $this->education,
            'courses' => $this->courses,

            'specializationsList' => $this->getSpecializationsList(),
            'specializations' => $this->getSpecializations(),
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
        $this->_courses = $this->createModels($data, 'site\frontend\modules\specialists\models\sub\Career');
    }

    public function getCourses()
    {
        return $this->_courses;
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
        return  array_map(function($row) {
            if (is_array($row)) {
                $model = new Career();
                $model->setAttributes($row);
            } else {
                $model = $row;
            }
            return $model;
        }, $data);
    }
}