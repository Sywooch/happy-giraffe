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
            /*
             * @todo валидация
             */
            array('name', 'safe'),
            array('birthday', 'date', 'format' => 'yyyy-M-d'),
        );
    }

    public function toJSON()
    {
        return \CMap::mergeArray(parent::toJSON(), array(
            'name' => $this->name,
            'gender' => $this->gender,
            'birthday' => $this->birthday,
            'description' => (string) $this->description,
            'userId' => (int) $this->userId,
        ));
    }
} 