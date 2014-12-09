<?php

namespace site\frontend\modules\family\widgets\MembersListWidget;
use site\frontend\modules\family\models\FamilyMember;

/**
 * @author Никита
 * @date 12/11/14
 */

class MembersListWidget extends \CWidget
{
    private $typePriority = array(
        'adult' => 0,
        'child' => 1,
        'waiting' => 2,
        'planning' => 3,
    );

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
        $aTypePriority = $this->typePriority[$a->type];
        $bTypePriority = $this->typePriority[$b->type];

        if ($aTypePriority == $bTypePriority) {
            if ($a->type == 'child') {
                $aTime = strtotime($a->birthday);
                $bTime = strtotime($b->birthday);
                if ($aTime == $bTime) {
                    return 0;
                }
                return (($aTime < $bTime) && ($aTime != 0)) ? -1 : 1;
            }
            if ($a->type == 'adult') {
                return ($this->isMe($a)) ? -1 : 1;
            }
            return 0;
        }

        return ($aTypePriority < $bTypePriority) ? -1 : 1;
    }


    public function isMe(FamilyMember $member)
    {
        return $member->userId == $this->me;
    }
} 