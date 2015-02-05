<?php
namespace site\frontend\modules\ads\components;
\Yii::import('site.common.vendor.Google.src.*');
require_once 'Google/Api/Ads/Dfp/Lib/DfpUser.php';
require_once 'Google/Api/Ads/Common/Util/MediaUtils.php';

/**
 * @author Никита
 * @date 04/02/15
 */

class DfpHelper
{
    public $advertiserId;

    public function __construct()
    {
        $this->advertiserId = 52506489;
    }

    public function addCreative()
    {
        $user = new \DfpUser();
        $user->LogDefaults();
        $creativeService = $user->GetService('CreativeService', 'v201411');
        $customCreative = new \CustomCreative();
        $customCreative->name = 'Custom creative';
        $customCreative->advertiserId = $this->advertiserId;
        $customCreative->destinationUrl = 'http://google.com';
        $customCreative->htmlSnippet = '<h1>Lol ok</h1>';
        $customCreative->size = new \Size(300, 250, FALSE);
        $customCreatives = $creativeService->createCreatives(array($customCreative));
        return $customCreatives[0]->previewUrl;
    }
}