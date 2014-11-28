<?php
/**
 * @author Никита
 * @date 19/11/14
 */

namespace site\frontend\modules\family\components;
use Aws\CloudFront\Exception\Exception;
use site\frontend\modules\family\models\Adult;
use site\frontend\modules\family\models\Child;
use site\frontend\modules\family\models\Family;
use site\frontend\modules\family\models\FamilyMember;
use site\frontend\modules\photo\models\PhotoAlbum;
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
    private $unsortedPhotos;

    public static function migrateAll($start)
    {
        Family::model()->deleteAll();
        $criteria = new \CDbCriteria(array(
            'order' => 'id ASC',
        ));
        if ($start != 1) {
            $criteria->compare('id', '>=' . $start);
        }
        $dp = new \CActiveDataProvider('User', array(
            'criteria' => $criteria,
        ));
        $iterator = new \CDataProviderIterator($dp, 100);
        foreach ($iterator as $user) {
            // безымянный юзер, не можем создать семью
            $name = trim($user->first_name);
            if (empty($name)) {
                continue;
            }

            echo $user->id . "\n";
            self::migrateSingle($user);
        }
    }

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

        $manager = new MigrateManager($user);
        $manager->convert();
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
            foreach ($this->user->babies as $baby) {
                $this->convertBaby($baby);
            }
        }

        if (count($this->unsortedPhotos) > 0) {
            $album = new PhotoAlbum();
            $album->title = 'Семейный альбом общие';
            $album->author_id = $this->user->id;
            if (! $album->save(false)) {
                throw new \CException('Невозможно создать общий альбом');
            }
            $album->photoCollection->attachPhotos($this->unsortedPhotos);
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
        $this->saveMember($member, $oldBaby);
    }

    protected function movePhotos($old, $new)
    {
        $photoIds = \site\frontend\modules\photo\components\MigrateManager::getByRelation($old);
        if ($photoIds > 5) {
            $album = new PhotoAlbum();
            $album->title = 'Семейный альбом' . $new->id;
            $album->author_id = ($old instanceof \Baby) ? $old->parent_id : $old->user_id;
            if (! $album->save(false)) {
                throw new \CException('Невозможно создать альбом члена семьи');
            }
            $album->photoCollection->attachPhotos($photoIds);
        } elseif ($photoIds > 0) {
            $this->unsortedPhotos += $photoIds;
        }

        if (count($photoIds) > 0) {
            $cover = $photoIds[0];
            if ($old->main_photo_id !== null) {
                $oldPhoto = \AlbumPhoto::model()->findByPk($old->main_photo_id);
                $newPhotoId = \site\frontend\modules\photo\components\MigrateManager::movePhoto($oldPhoto);
                if ($newPhotoId !== false) {
                    $cover = $newPhotoId;
                }
            }
            $new->photoCollection->attachPhotos(array($cover));
        }
    }

    protected function saveMember(FamilyMember $member, $old)
    {
        $member->familyId = $this->family->id;
        $member->family = $this->family;
        $isValid = $member->validate();
        $errors = $member->errors;

        if (! $isValid && ! $this->isExcepted($old, $errors)) {
            echo get_class($old) . "\n";
            echo $old->id . "\n";
            print_r($member->errors);
            \Yii::app()->end();
        }
        if (! $member->save(false)) {
            throw new \CException('Невозможно создать члена семьи');
        }
        $this->movePhotos($old, $member);
    }

    protected function isExcepted($model, $errors)
    {
        $allowedErrors = array();

        if ($model instanceof \Baby) {
            if ($model->type == \Baby::TYPE_WAIT || $model->type == \Baby::TYPE_TWINS) {
                $allowedErrors = array(
                    'birthday' => array(
                        'Некорректная дата родов',
                        'Необходимо заполнить поле «Birthday».',
                        'Неправильный формат поля Birthday.', // 2012-12-00
                    ),
                    'type' => array(
                        'В семье может быть только один ожидаемый ребенок',
                    ),
                );
            }

            if ($model->type == \Baby::TYPE_PLANNING) {
                $allowedErrors = array(
                    'planningWhen' => array(
                        'Необходимо заполнить поле «Planning When».',
                    ),
                    'type' => array(
                        'В семье может быть только один ожидаемый ребенок',
                    ),
                );
            }

            if ($model->type == null) {
                $allowedErrors = array(
                    'birthday' => array(
                        'Необходимо заполнить поле «Birthday».',
                        'Неправильный формат поля Birthday.', // 0000-00-00
                    ),
                    'name' => array(
                        'Необходимо заполнить поле «Name».',
                    ),
                    'gender' => array(
                        'Необходимо заполнить поле «Gender».',
                    ),
                );
            }
        }

        if ($model instanceof \UserPartner) {
            $allowedErrors = array(
                'name' => array(
                    'Необходимо заполнить поле «Name».',
                ),
            );
        }

        foreach ($allowedErrors as $attribute => $texts) {
            foreach ($texts as $text) {
                if (isset($errors[$attribute]) && ($index = array_search($text, $errors[$attribute])) !== false) {
                    unset($errors[$attribute][$index]);
                    if (count($errors[$attribute]) == 0) {
                        unset($errors[$attribute]);
                    }
                }
            }
        }

        return count($errors) == 0;
    }
} 