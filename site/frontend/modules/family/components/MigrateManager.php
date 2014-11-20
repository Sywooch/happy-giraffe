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

    private static $_babyTypeMap = array(
        \Baby::TYPE_PLANNING => 'planning',
        \Baby::TYPE_TWINS => 'waiting',
        \Baby::TYPE_WAIT => 'waiting',
        null => 'child',
    );

    private $user;
    private $family;

    public static function migrateSingle($userId)
    {
        Family::model()
        $user = User::model()->findByPk($userId);
        if ($user !== null) {
            $manager = new MigrateManager($user);
            $manager->convert();
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
        $this->saveMember($partner, $oldPartner);
    }

    protected function convertBaby(\Baby $oldBaby)
    {
        $type = self::$_babyTypeMap[$oldBaby->type];
        $class = FamilyMember::getClassName($type);
        $member = new $class();
        $member->type = $type;
        $member->gender = self::$_babyGender[$oldBaby->sex];
        switch ($oldBaby->type) {
            case null:
                $member->name = $oldBaby->name;
                $member->birthday = $oldBaby->birthday;
                $member->description = $oldBaby->notice;
                break;
            case \Baby::TYPE_PLANNING:
                break;
            case \Baby::TYPE_WAIT:
                $member->birthday = $oldBaby->birthday;
                break;
            case \Baby::TYPE_TWINS:
                $member->birthday = $oldBaby->birthday;
                break;
        }
        $member->familyId = $this->family->id;
        $this->saveMember($member, $oldBaby);
    }

    protected function saveMember(FamilyMember $member, $old)
    {
        if (! $member->save()) {
            echo get_class($old) . "\n";
            echo $old->id . "\n";
            print_r($member->errors);
            \Yii::app()->end();
        }
        return true;
    }
} 