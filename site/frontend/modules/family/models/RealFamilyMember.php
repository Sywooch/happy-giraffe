<?php
/**
 * @author Никита
 * @date 23/10/14
 */

namespace site\frontend\modules\family\models;


abstract class RealFamilyMember extends FamilyMemberAbstract
{
    public function rules()
    {
        return array(
            array('name', 'safe'),
        );
    }

    public function toJSON()
    {
        return \CMap::mergeArray(parent::toJSON(), array(
            'name' => $this->name,
            'gender' => $this->gender,
            'birthday' => $this->birthday,
            'description' => (string) $this->description,
            'userId' => $this->userId,
        ));
    }
} 