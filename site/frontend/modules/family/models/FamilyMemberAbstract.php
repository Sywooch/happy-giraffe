<?php
/**
 * @author Никита
 * @date 23/10/14
 */

namespace site\frontend\modules\family\models;


abstract class FamilyMemberAbstract extends FamilyMember
{
    protected $viewData;

    /**
     * @return \site\frontend\modules\family\models\viewData\FamilyMemberViewData
     */
    public function getViewData()
    {
        if ($this->viewData === null) {
            $this->viewData = $this->getViewDataInternal();
        }

        return $this->viewData;
    }

    abstract protected function getViewDataInternal();
} 