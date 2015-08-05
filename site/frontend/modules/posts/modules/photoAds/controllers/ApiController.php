<?php
namespace site\frontend\modules\posts\modules\photoAds\controllers;
use site\frontend\modules\posts\modules\photoAds\components\PhotoAdsManager;

/**
 * @author Никита
 * @date 28/07/15
 */

class ApiController extends \site\frontend\components\api\ApiController
{
    const COOKIE_NAME = 'PhotoAds4';
    const CAP = 2;

    public function actionGetPosts($url, $limit = -1)
    {
        $manager = new PhotoAdsManager();
        $posts = $manager->getPosts($url, false, $limit);
        $this->data = $posts;
        $this->success = true;
    }

    public function actionGetAdPosts($url, $limit = 1)
    {
        if (isset(\Yii::app()->request->cookies[self::COOKIE_NAME])) {
            $this->data = array();
        } else {
            $cookieValue = isset(\Yii::app()->request->cookies[self::COOKIE_NAME]) ? unserialize(\Yii::app()->request->cookies[self::COOKIE_NAME]->value) : array();

            if (count($cookieValue) >= 2) {
                $this->data = array();
            } else {
                $manager = new PhotoAdsManager();
                $posts = $manager->getPosts($url, false, $limit, $cookieValue);
                foreach ($posts as $p) {
                    $cookieValue[] = $p['post']->id;
                }
                \Yii::app()->request->cookies[self::COOKIE_NAME] = new \CHttpCookie(self::COOKIE_NAME, serialize($cookieValue));

                $this->data = $posts;
            }
        }
        $this->success = true;
    }
}