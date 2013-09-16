<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 9/11/13
 * Time: 3:33 PM
 * To change this template use File | Settings | File Templates.
 */

class UserFamilyWidget extends CWidget
{
    public $user;

    public function run()
    {
        $data = array();

        if ($this->user->partner !== null) {
            $thumbSrc = $this->getThumbSrc($this->user->partner);
            $iconCssClass = $this->getAdultCssClass(($this->user->gender + 1) % 2, $this->user->relationship_status);
            $name = $this->user->partner->name;
            $title = $this->getPartnerTitle();
            $age = '';
            $data[] = compact('thumbSrc', 'name', 'iconCssClass', 'title', 'age');
        }

        foreach ($this->user->babies as $b) {
            if ($b->type == 1) {
                if (time() > strtotime($b->birthday))
                    continue;
            }
            $thumbSrc = $this->getThumbSrc($b);
            $iconCssClass = $this->getBabyCssClass($b);
            $name = $b->name;
            $title = $this->getBabyTitle($b);
            $age = $b->getTextAge();
            $data[] = compact('thumbSrc', 'name', 'iconCssClass', 'title', 'age');
        }

        if (count($data) > 0)
            $this->render('UserFamilyWidget', compact('data', 'showMore', 'membersCount'));
    }

    protected function getThumbSrc($model)
    {
        $thumbUrl = null;
        if (count($model->photos) > 0) {
            if ($model->main_photo_id !== null) {
                foreach ($model->photos as $p)
                    if ($p->id == $model->main_photo_id)
                        $photoAttach = $p;
            } else
                $photoAttach = $model->photos[0];
            if ($photoAttach){
                $photo = $photoAttach->photo;
                $thumbUrl = $photo->getPreviewUrl(55, 55, Image::AUTO);
            }
        }

        return $thumbUrl;
    }

    protected function getPartnerTitle()
    {
        if ($this->user->gender == 0) {
            switch ($this->user->relationship_status) {
                case 1:
                    return 'Муж';
                case 3:
                    return 'Жених';
                case 4:
                    return 'Друг';
            }
        } else {
            switch ($this->user->relationship_status) {
                case 1:
                    return 'Жена';
                case 3:
                    return 'Невеста';
                case 4:
                    return 'Подруга';
            }
        }
    }

    protected function getAdultCssClass($gender, $relationshipStatus)
    {
        if ($gender == 0) {
            switch ($relationshipStatus) {
                case null:
                case 1:
                case 2:
                    return 'wife';
                case 3:
                    return 'girl-friend';
                case 4:
                    return 'bride';
            }
        } else {
            switch ($relationshipStatus) {
                case null:
                case 1:
                case 2:
                    return 'husband';
                case 3:
                    return 'boy-friend';
                case 4:
                    return 'fiance';
            }
        }
    }

    protected function getBabyCssClass($model)
    {
        switch ($model->type) {
            case null:
                switch ($model->age_group) {
                    case 0:
                        $ageWord = 'small';
                        break;
                    case 1:
                        $ageWord = '3';
                        break;
                    case 2:
                        $ageWord = '5';
                        break;
                    case 3:
                        $ageWord = '8';
                        break;
                    case 4:
                        $ageWord = '14';
                        break;
                    case 5:
                        $ageWord = '19';
                        break;
                }

                return ($model->sex == 1 ? 'boy' : 'girl') . ($model->age_group !== null ? '-' . $ageWord : '');
            case 1:
                switch ($model->sex) {
                    case 0:
                        return 'girl-wait';
                    case 1:
                        return 'boy-wait';
                    case 2:
                        return 'baby';
                }
            case 2:
                return 'baby-plan';
            case 3:
                return 'baby-two';
        }
    }

    protected function getBabyTitle($model)
    {
        switch ($model->type) {
            case null:
                return $model->sex == 1 ? 'Сын' : 'Дочь';
            case 1:
                switch ($model->sex) {
                    case 0:
                        return 'Ждем девочку';
                    case 1:
                        return 'Ждем мальчика';
                    case 2:
                        return 'Ждем ребенка';
                }
            case 3:
                return 'Ждем двойню';
        }
    }
}