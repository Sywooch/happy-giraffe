<?php
/**
 * @author Никита
 * @date 23/10/14
 */

namespace site\frontend\modules\family\models;


use site\frontend\modules\family\components\AgeHelper;
use site\frontend\modules\family\models\viewData\ChildViewData;

class Child extends FamilyMemberAbstract
{
    public $type = 'child';

    static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    protected function getViewDataInternal()
    {
        return new ChildViewData($this);
    }

    /**
     * @return NULL|\site\frontend\modules\som\modules\qa\models\NULL|\site\frontend\modules\som\modules\qa\models\QaTag
     */
    public function getAgeTag()
    {
        return $this->getViewDataInternal()->getAgeTag();
    }

    public function getAnswerFooterData()
    {
         $data = [
             'childName' => 'Без имени',
             'imgUrl' => '#',
             'tag' => NULL,
         ];

        try {
            $data['childName']  = $this->name;
            $data['imgUrl']     = $this->photoCollection->attaches[0]->photo->getPreviewPhoto();
            $data['tag']        = $this->getViewDataInternal()->getAgeTag();
        } catch (\Exception $e)
        {}

        return $data;
    }

    public function rules()
    {
        return \CMap::mergeArray(parent::rules(), array(
            array('gender, birthday, name', 'required', 'on' => 'insert, update'),
            array('gender', 'in', 'range' => array(self::GENDER_MALE, self::GENDER_FEMALE)),
            array('birthday', 'date', 'format' => 'yyyy-M-d'),
            array('birthday', 'validateBirthday'),
            array('name', 'length', 'max' => 50),
            array('description', 'length', 'max' => 1000),
        ));
    }

    public function validateBirthday($attribute)
    {
        if (time() < strtotime($this->$attribute)) {
            $this->addError($attribute, 'Некорректная дата рождения');
        }
    }

    public function toJSON()
    {
        return \CMap::mergeArray(parent::toJSON(), array(
            'gender' => $this->gender,
            'birthday' => $this->birthday,
            'name' => $this->name,
            'description' => $this->description,
            'ageString' => AgeHelper::getChildAgeString($this->birthday),
            'photoCollection' => $this->photoCollection,
        ));
    }

}