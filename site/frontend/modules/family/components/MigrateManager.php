<?php
/**
 * @author Никита
 * @date 19/11/14
 */

namespace site\frontend\modules\family\components;
use site\frontend\modules\family\models\Adult;
use site\frontend\modules\family\models\Child;
use site\frontend\modules\family\models\Family;
use site\frontend\modules\family\models\FamilyMember;
use site\frontend\modules\photo\models\User;

class MigrateManager
{
    private static $_statusMap = array(
        1 => Adult::STATUS_MARRIED,
        3 => Adult::STATUS_ENGAGED,
        4 => Adult::STATUS_FRIENDS,
    );

    private static $_babyGender = array(
        0 => FamilyMember::GENDER_FEMALE,
        1 => FamilyMember::GENDER_MALE,
        2 => null,
    );

    private $user;
    private $family;

    public static function migrateSingle($userId)
    {
        $user = User::model()->findAll($userId);
        if ($user !== null) {
            $manager = new MigrateManager($user);
            return $manager->convert();
        }
    }

    public function __construct(\User $user)
    {
        $this->user = $user;
    }

    public function convert()
    {
        if (! $this->hasFamily()) {
            return;
        }

        $this->family = Family::createFamily($this->user->id);
        if ($this->hasPartner()) {
            $this->convertPartner();
        }
        if ($this->hasBabies()) {
            foreach ($this->user->babies as $baby) {
                $this->convertBaby($baby);
            }
        }
    }

    protected function hasFamily()
    {
        return $this->hasPartner() || $this->hasBabies();
    }

    protected function hasPartner()
    {
        return in_array($this->user->relationship_status, array_keys(self::$_statusMap)) && $this->user->partner !== null;
    }

    protected function hasBabies()
    {
        return ! empty ($this->user->babies);
    }

    protected function convertPartner()
    {
        $oldPartner = $this->user->partner;
        $partner = new Adult();
        $partner->name = $oldPartner->name;
        $partner->description = $oldPartner->notice;
        $partner->relationshipStatus = self::$_statusMap[$this->user->relationship_status];
        $partner->familyId = $this->family->id;
        $partner->save(false);
        \site\frontend\modules\photo\components\MigrateManager::moveAttachCollection($oldPartner, $partner);
    }

    protected function convertBaby(\Baby $oldBaby)
    {
        $member = new FamilyMember();
        $member->gender = self::$_babyGender[$oldBaby->gender];
        switch ($oldBaby->type) {
            case null:
                $member->type = 'child';
                $member->name = $oldBaby->name;
                $member->birthday = $oldBaby->birthday;
                $member->description = $oldBaby->notice;
                break;
            case \Baby::TYPE_PLANNING:
                $member->type = 'planning';
                break;
            case \Baby::TYPE_WAIT:
                $member->type = 'waiting';
                $member->birthday = $oldBaby->birthday;
                break;
            case \Baby::TYPE_TWINS:
                $member->type = 'waiting';
                $member->birthday = $oldBaby->birthday;
                break;
        }
        $member->familyId = $this->family->id;
        $member->save(false);
        \site\frontend\modules\photo\components\MigrateManager::moveAttachCollection($oldBaby, $member);
    }
} 