<?php
namespace site\frontend\modules\posts\modules\photoAds\controllers;
use site\frontend\modules\posts\modules\photoAds\components\PhotoAdsManager;

/**
 * @author Никита
 * @date 28/07/15
 */

class ApiController extends \site\frontend\components\api\ApiController
{
    public function actionGetPosts($url, $limit = -1)
    {
        $manager = new PhotoAdsManager();
        $posts = $manager->getPosts($url);
        $this->data = $posts;
        $this->success = true;
    }
}