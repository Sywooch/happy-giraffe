<?php

namespace site\frontend\modules\family\widgets\MembersListWidget;
use site\frontend\modules\family\models\FamilyMember;

/**
 * @author Никита
 * @date 12/11/14
 */

class MembersListWidget extends \CWidget
{
    /** @var \site\frontend\modules\family\models\FamilyMember */
    public $family;

    public $view;

    public function run()
    {
        $members = $this->family->getMembers(null, false);
        usort($members, array($this, 'sort'));
        $this->render($this->view, compact('members'));
    }

    protected function sort(FamilyMember $a, FamilyMember $b)
    {
        $priorityA = $this->getPriority($a);
        $priorityB = $this->getPriority($b);

        if ($priorityA == $priorityB) {
            return 0;
        }
        return ($priorityA < $priorityB) ? -1 : 1;
    }

    protected function getPriority(FamilyMember $a)
    {
        if ($a->type == FamilyMember::TYPE_ADULT) {
            return ($a->userId == \Yii::app()->user->id) ? -1 : 0;
        }
        return 1;
    }
} 