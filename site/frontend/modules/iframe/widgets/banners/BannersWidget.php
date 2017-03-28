<?php

namespace site\frontend\modules\iframe\widgets\banners;


/**
 * Баннер в iframe приложении
 */
class BannersWidget extends \CWidget
{

    public $banner;

    public function run()
    {
        $this->render('view', [
            'banner' => $this->banner,
        ]);
    }

}