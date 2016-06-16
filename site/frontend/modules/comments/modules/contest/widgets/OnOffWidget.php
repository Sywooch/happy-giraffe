<?php

namespace site\frontend\modules\comments\modules\contest\widgets;

/**
 * @author crocodile
 * 
 */
class OnOffWidget extends \CWidget
{

    public $model;
    public $preset;
    public $line;
    public $title;

    public function run()
    {
        $this->render('OnOffWidget');
    }

    public function getIsActive()
    {

        return \Favourites::model()->inFavourites($this->model->communityContent, \Favourites::BLOCK_COMMENTATORS_CONTEST);
    }

    public function getParams()
    {
        return array(
            'modelPk' => $this->model->id,
        );
    }

}
