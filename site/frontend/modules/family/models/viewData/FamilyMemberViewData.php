<?php

namespace site\frontend\modules\family\models\viewData;
use site\frontend\modules\family\models\FamilyMember;

/**
 * @author Никита
 * @date 12/11/14
 */

abstract class FamilyMemberViewData
{
    protected $model;

    public function __construct(FamilyMember $member)
    {
        $this->model = $member;
    }

    abstract public function getTitle();
    abstract public function getCssClass();
    abstract public function getAsString();
} 