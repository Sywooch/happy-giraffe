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
} 