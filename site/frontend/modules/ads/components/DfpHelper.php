<?php
namespace site\frontend\modules\ads\components;
\Yii::import('site.common.vendor.Google.src.*');
require_once 'Google/Api/Ads/Dfp/Lib/DfpUser.php';
require_once 'Google/Api/Ads/Common/Util/MediaUtils.php';

/**
 * @author Никита
 * @date 04/02/15
 */

class DfpHelper extends \CApplicationComponent
{
    public $advertiserId;
    protected $user;

    public function init()
    {
        $this->user = $this->logIn();
        parent::init();
    }

    public function addCreative(CreativeInfoProvider $info)
    {
        $creativeService = $this->user->GetService('CreativeService', 'v201411');
        $customCreative = new \CustomCreative();
        $customCreative->name = $info->getName();
        $customCreative->advertiserId = $this->advertiserId;
        $customCreative->destinationUrl = $info->getUrl();
        $customCreative->htmlSnippet = $info->getHtml();
        $customCreative->size = new \Size(300, 250, FALSE);
        $customCreatives = $creativeService->createCreatives(array($customCreative));
        return $customCreatives[0];
    }

    public function addLica($lineId, $creativeId)
    {
        $licaService = $this->user->GetService('LineItemCreativeAssociationService', 'v201411');
        $lica = new \LineItemCreativeAssociation();
        $lica->creativeId = $creativeId;
        $lica->lineItemId = $lineId;
        $licas = array($lica);
        $licas = $licaService->createLineItemCreativeAssociations($licas);
        return $licas[0];
    }

    protected function logIn()
    {
        $user = new \DfpUser();
        $user->LogDefaults();
        return $user;
    }
}