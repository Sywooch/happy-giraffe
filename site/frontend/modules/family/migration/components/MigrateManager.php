<?php
/**
 * @author Никита
 * @date 19/11/14
 */

namespace site\frontend\modules\family\migration\components;
use Aws\CloudFront\Exception\Exception;
use site\frontend\modules\family\models\Adult;
use site\frontend\modules\family\models\Child;
use site\frontend\modules\family\models\Family;
use site\frontend\modules\family\models\FamilyMember;
use site\frontend\modules\family\models\PregnancyChild;
use site\frontend\modules\photo\models\PhotoAlbum;
use site\frontend\modules\photo\models\PhotoCollection;
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
    private $unsortedPhotos = array();

    public static function migrateSingle($user)
    {
        $family = Family::model()->hasMember($user->id)->find();
        if ($family !== null) {
            return;
        }
        $name = trim($user->first_name);
        if (empty($name)) {
            return;
        }

        echo $user->id . "\n";
        $transaction = \Yii::app()->db->beginTransaction();
        try {
            $manager = new MigrateManager($user);
            $manager->convert();
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollback();
            throw $e;
        }

    }

    public static function clean()
    {
        \Yii::app()->db->createCommand("DELETE photo__collections
FROM photo__collections
JOIN photo__albums ON photo__albums.id = photo__collections.entity_id AND photo__collections.entity = 'PhotoAlbum'
WHERE photo__albums.source = 'family';")->execute();
        \Yii::app()->db->createCommand("DELETE
FROM photo__collections
WHERE entity = 'Family';")->execute();
        \Yii::app()->db->createCommand("DELETE
FROM photo__collections
WHERE entity = 'FamilyMember';")->execute();
        \Yii::app()->db->createCommand("DELETE
FROM photo__albums
WHERE source = 'family';")->execute();
        \Yii::app()->db->createCommand("DELETE
FROM family__families;")->execute();
        \Yii::app()->db->createCommand("ALTER TABLE family__families AUTO_INCREMENT = 0;")->execute();
        \Yii::app()->db->createCommand("ALTER TABLE family__members AUTO_INCREMENT = 0;")->execute();
    }

    public function __construct(\User $user)
    {
        $this->user = $user;
    }

    protected function convert()
    {
        if (! $this->hasFamily()) {
            return;
        }

        $this->family = Family::createFamily($this->user->id);

        if ($this->family === null) {
            throw new \CException('Невозможно создать семью');
        }

        if ($this->hasPartner()) {
            $this->convertPartner();
        }
        if ($this->hasBabies()) {
            $babies = $this->getBabies();
            foreach ($babies as $baby) {
                $this->convertBaby($baby);
            }
        }

        if (count($this->unsortedPhotos) > 0) {
            $album = new PhotoAlbum();
            $album->title = 'Семейный альбом общие';
            $album->author_id = $this->user->id;
            $album->source = 'family';
            if (! $album->save(false)) {
                throw new \CException('Невозможно создать общий альбом');
            }
            $album->photoCollection->attachPhotos($this->unsortedPhotos);
        }
    }

    protected function getBabies()
    {
        $waitingBabies = array();
        $babies = array();
        foreach ($this->user->babies as $baby) {
            if (in_array($baby->type, array(\Baby::TYPE_WAIT, \Baby::TYPE_TWINS, \Baby::TYPE_PLANNING))) {
                $waitingBabies[] = $baby;
            } else {
                $babies[] = $baby;
            }
        }

        $nWaitingBabies = count($waitingBabies);
        if ($nWaitingBabies > 0) {
            if ($nWaitingBabies > 1) {
                usort($waitingBabies, array($this, 'waitingBabiesCmp'));
            }
            $babies[] = $waitingBabies[0];
        }

        return $babies;
    }

    protected function waitingBabiesCmp(\Baby $a, \Baby $b) {
        $aIsPregnancy = in_array($a->type, array(\Baby::TYPE_WAIT, \Baby::TYPE_TWINS));
        $bIsPregnancy = in_array($b->type, array(\Baby::TYPE_WAIT, \Baby::TYPE_TWINS));

        if (! $aIsPregnancy && ! $bIsPregnancy) {
            return 0;
        }

        if ($aIsPregnancy != $bIsPregnancy) {
            return ($aIsPregnancy) ? -1 : 1;
        }

        $aTime = (int) strtotime($a->birthday);
        $bTime = (int) strtotime($b->birthday);

        if ($aTime == $bTime) {
            return ($a->id > $b->id) ? -1 : 1;
        } else {
            return ($aTime > $bTime) ? -1 : 1;
        }
    }

    protected function hasFamily()
    {
        return $this->hasPartner() || $this->hasBabies();
    }

    protected function hasPartner()
    {
        return $this->user->partner !== null;
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
        $status = (isset(self::$_statusMap[$this->user->relationship_status]) ? self::$_statusMap[$this->user->relationship_status] : Adult::STATUS_FRIENDS);
        $partner->relationshipStatus = $status;
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
                $member->birthday = $this->fixBirthdayDate($oldBaby->birthday);
                $member->description = $oldBaby->notice;
                break;
            case \Baby::TYPE_PLANNING:
                break;
            case \Baby::TYPE_WAIT:
                $member->birthday = $this->fixPregnancyDate($oldBaby->birthday);
                break;
            case \Baby::TYPE_TWINS:
                $member->birthday = $this->fixPregnancyDate($oldBaby->birthday);
                break;
        }
        $this->saveMember($member, $oldBaby);
    }

    protected function fixPregnancyDate($date)
    {
        $d = \CDateTimeParser::parse($date, 'yyyy-M-d');
        if ($d === false) {
            return null;
        }
        $now = new \DateTime();
        $birthday = new \DateTime($date);
        $interval = $now->diff($birthday);

        if ($interval->invert == 0 && (($interval->y > 0) || ($interval->m > PregnancyChild::PREGNANCY_MONTHS))) {
            $dtFixed = clone $now;
            $dtFixed->modify('+9 month');
            return $dtFixed->format('Y-m-d');
        }
        return $date;
    }

    public function fixBirthdayDate($date)
    {
        $d = \CDateTimeParser::parse($date, 'yyyy-M-d');
        if ($d === false) {
            return null;
        }
        return $date;
    }

    protected function saveMember(FamilyMember $member, $old)
    {
        $member->familyId = $this->family->id;
        $member->family = $this->family;

        if (! $member->save(false)) {
            throw new \CException('Невозможно создать члена семьи');
        }
        $this->movePhotos($old, $member);
    }

    protected function movePhotos($old, $new)
    {
        $photoIds = \site\frontend\modules\photo\components\MigrateManager::getByRelation($old);
        $photosCount = count($photoIds);

        if ($photosCount > 0) {
            $cover = $photoIds[0];
            if ($old->main_photo_id !== null) {
                $oldPhoto = \AlbumPhoto::model()->findByPk($old->main_photo_id);
                $newPhotoId = \site\frontend\modules\photo\components\MigrateManager::movePhoto($oldPhoto);
                if ($newPhotoId !== false) {
                    $cover = $newPhotoId;
                }
            }
            $new->photoCollection->attachPhotos(array($cover));

            if ($photosCount > 1) {
                $remainingPhotosIds = $photoIds;
                $coverKey = array_search($cover, $photoIds);
                if ($coverKey !== false) {
                    unset($remainingPhotosIds[$coverKey]);
                }

                if ($photosCount > 4) {
                    $album = new PhotoAlbum();
                    $memberName = trim($new->name);
                    $albumTitle = $new->viewData->getTitle() . ((! empty($memberName)) ? ' ' . $new->name : '');
                    $album->title = $albumTitle;
                    $album->author_id = ($old instanceof \Baby) ? $old->parent_id : $old->user_id;
                    $album->source = 'family';
                    if (! $album->save(false)) {
                        throw new \CException('Невозможно создать альбом члена семьи');
                    }
                    $album->photoCollection->attachPhotos($remainingPhotosIds);
                } else {
                    $this->unsortedPhotos += $remainingPhotosIds;
                }
            }
        }
    }
} 