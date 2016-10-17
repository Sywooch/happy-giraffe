<?php

/**
 * @author Никита
 * @date 14/10/16
 */

namespace site\frontend\modules\specialists\modules\pediatrician\widgets\rating;

use site\frontend\modules\specialists\modules\pediatrician\components\RatingManager;

class RatingWidget extends \CWidget
{
    const TOP_COUNT = 3;

    public $perPage;
    public $page;
    
    /** @var  RatingManager */
    protected $ratingManager;
    
    public function init()
    {
        $this->ratingManager = new RatingManager();
        parent::init();
    }

    public function run()
    {
        $rating = $this->getRating();
        $top = array_slice($rating, 0, self::TOP_COUNT);
        $others = array_slice($rating, self::TOP_COUNT);
        $this->render('rating', compact('top', 'others'));
    }

    public function showButton()
    {
        return $this->getLimit() < $this->ratingManager->getCount();
    }

    public function getNextUrl()
    {
        return \Yii::app()->createUrl('/specialists/pediatrician/default/rating', ['page' => $this->page + 1]);
    }

    protected function getLimit()
    {
        return $this->page * $this->perPage + self::TOP_COUNT;
    }

    protected function getRating()
    {
        return $this->ratingManager->getRating($this->getLimit());
    }
}