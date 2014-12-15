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
    const BLOCK_WIDTH = 880;
    const PHOTO_SIDE_LEFT = 0;
    const PHOTO_SIDE_RIGHT = 1;

    protected $colors = array('green', 'carrot', 'blue', 'lilac');
    protected static $iterator = 0;

    /** @var \site\frontend\modules\family\models\FamilyMemberAbstract */
    public $model;

    public $view;

    public function run()
    {
        $this->render('index');
    }

    public function getPhotoSide()
    {
        return (self::$iterator % 2) ? self::PHOTO_SIDE_LEFT : self::PHOTO_SIDE_RIGHT;
    }

    public function getColor()
    {
        $index = self::$iterator % count($this->colors);
        self::$iterator++;
        return $this->colors[$index];
    }

    public function getInfoWidth()
    {
        $attach = $this->model->photoCollection->observer->getSingle(0);
        $thumb = \Yii::app()->thumbs->getThumb($attach->photo, 'familyMemberImage');
        return (880 - $thumb->getWidth());
    }
} 