<?php

namespace site\frontend\modules\family\widgets\FamilyMemberWidget;
use site\frontend\modules\family\models\Adult;
use site\frontend\modules\family\models\FamilyMember;
use site\frontend\modules\family\models\PregnancyChild;

/**
 * @author Никита
 * @date 12/11/14
 */

class FamilyMemberWidget extends \CWidget
{
    /** @var \site\frontend\modules\family\models\FamilyMemberAbstract */
    public $model;

    public $view;

    public function run()
    {
        $viewData = $this->model->getViewData();
        $isMe = ! \Yii::app()->user->isGuest && ($this->model->userId == \Yii::app()->user->id);
        $asString = $isMe ? 'Я' : $viewData->getAsString();
        $cssClass = $viewData->getCssClass();

        $this->render($this->view, compact('asString', 'cssClass'));
    }
} 