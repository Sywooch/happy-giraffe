<?php
namespace site\frontend\modules\ads\components;
\Yii::import('site.common.vendor.Google.src.*');
require_once 'Google/Api/Ads/Dfp/Lib/DfpUser.php';
require_once 'Google/Api/Ads/Common/Util/MediaUtils.php';
require_once 'Google/Api/Ads/Dfp/Util/DateTimeUtils.php';
require_once 'Google/Api/Ads/Dfp/Util/StatementBuilder.php';

/**
 * @author Никита
 * @date 04/02/15
 */

class DfpHelper extends \CApplicationComponent
{
    const LICA_DEACTIVATE = 2;
    const LICA_ACTIVATE = 1;

    public $advertiserId;
    public $version;

    protected $user;

    public function init()
    {
        $this->user = $this->logIn();
        parent::init();
    }

    public function addCreative(array $options, array $size)
    {
        $creativeService = $this->getService('CreativeService');
        $customCreative = new \CustomCreative();
        $customCreative->advertiserId = $this->advertiserId;
        $customCreative->size = new \Size($size['width'], $size['height'], false);
        foreach ($options as $option => $value) {
            if (property_exists($customCreative, $option)) {
                $customCreative->$option = $value;
            }
        }
        $customCreatives = $creativeService->createCreatives(array($customCreative));
        return $customCreatives[0];
    }

    public function addLica($lineId, $creativeId)
    {
        $licaService = $this->getService('LineItemCreativeAssociationService');
        $lica = new \LineItemCreativeAssociation();
        $lica->creativeId = $creativeId;
        $lica->lineItemId = $lineId;
        $lica->endDateTime = \DateTimeUtils::ToDfpDateTime(new \DateTime('+2 day', new \DateTimeZone('Europe/Moscow')));
        $licas = array($lica);
        $licas = $licaService->createLineItemCreativeAssociations($licas);
        return $licas[0];
    }

    public function activateLica($lineId, $creativeId)
    {
        $this->updateLicaStatus($lineId, $creativeId, self::LICA_ACTIVATE);
    }

    public function deactivateLica($lineId, $creativeId)
    {
        $this->updateLicaStatus($lineId, $creativeId, self::LICA_DEACTIVATE);
    }

    protected function updateLicaStatus($lineId, $creativeId, $action)
    {
        $licaService = $this->user->GetService('LineItemCreativeAssociationService', 'v201411');
        $statementBuilder = $this->prepareLicaStatement($lineId, $creativeId);

        $action = ($action == self::LICA_DEACTIVATE) ?
            new \DeactivateLineItemCreativeAssociations() :
            new \ActivateLineItemCreativeAssociations();
        $result = $licaService->performLineItemCreativeAssociationAction($action, $statementBuilder->ToStatement());
    }

    protected function prepareLicaStatement($lineId, $creativeId)
    {
        $statementBuilder = new \StatementBuilder();
        $statementBuilder->Where(
            'lineItemId = :lineItemId AND creativeId = :creativeId')
            ->WithBindVariableValue('lineItemId', $lineId)
            ->WithBindVariableValue('creativeId', $creativeId);
        return $statementBuilder;
    }

    protected function getService($service)
    {
        return $this->user->GetService($service, $this->version);
    }

    protected function logIn()
    {
        $user = new \DfpUser();
        $user->LogDefaults();
        return $user;
    }
}