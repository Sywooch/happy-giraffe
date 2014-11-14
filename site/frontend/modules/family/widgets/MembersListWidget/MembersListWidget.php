<?php

namespace site\frontend\modules\family\widgets\MembersListWidget;
use site\frontend\modules\family\models\FamilyMember;

/**
 * @author Никита
 * @date 12/11/14
 */

class MembersListWidget extends \CWidget
{
    protected $colorIterator = 0;

    /** @var \site\frontend\modules\family\models\Family */
    public $family;
    public $view;
    public $me;

    public function run()
    {
        $members = $this->family->getMembers();
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
            return ($this->isMe($a)) ? -1 : 0;
        }
        return 1;
    }

    public function isMe(FamilyMember $member)
    {
        return $member->userId == $this->me;
    }
} 