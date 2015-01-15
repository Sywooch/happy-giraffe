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

    public function toJSON()
    {
        return \CMap::mergeArray(parent::toJSON(), array(
            'viewData' => array(
                'title' => $this->getViewData()->getTitle(),
                'cssClass' => $this->getViewData()->getCssClass(),
                'asString' => $this->getViewData()->getAsString(),
            ),
        ));
    }

    abstract protected function getViewDataInternal();
} 