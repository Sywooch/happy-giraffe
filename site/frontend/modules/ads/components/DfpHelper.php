<?php
namespace site\frontend\modules\ads\components;
\Yii::import('site.common.vendor.Google.src.*');
require_once 'Google/Api/Ads/Dfp/Lib/DfpUser.php';
require_once 'Google/Api/Ads/Common/Util/MediaUtils.php';
require_once 'Google/Api/Ads/Dfp/Util/DateTimeUtils.php';
require_once 'Google/Api/Ads/Dfp/Util/StatementBuilder.php';
require_once 'Google/Api/Ads/Common/Util/Logger.php';

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
    public $enableLogs;

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
        $this->setOptions($customCreative, $options);
        $customCreatives = $creativeService->createCreatives(array($customCreative));
        return $customCreatives[0];
    }

    public function updateCreative(array $options, $id)
    {
        $creativeService = $this->getService('CreativeService');
        $creative = $this->getCreative($id);
        $this->setOptions($creative, $options);
        $creatives = $creativeService->updateCreatives(array($creative));
    }

    public function getCreative($id)
    {
        $creativeService = $this->getService('CreativeService');
        $statementBuilder = new \StatementBuilder();
        $statementBuilder->Where('id = :id')
            ->OrderBy('id ASC')
            ->Limit(1)
            ->WithBindVariableValue('id', $id);
        $page = $creativeService->getCreativesByStatement($statementBuilder->ToStatement());
        $creative = $page->results[0];
        return $creative;
    }

    protected function setOptions(&$creative, $options)
    {
        foreach ($options as $option => $value) {
            if (property_exists($creative, $option)) {
                if ($value instanceof \DateTime) {
                    $value = \DateTimeUtils::ToDfpDateTime($value);
                }
                $creative->$option = $value;
            }
        }
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

    public function updateLica($lineId, $creativeId, $options)
    {
        $licaService = $this->user->GetService('LineItemCreativeAssociationService', 'v201411');
        $statementBuilder = $this->prepareLicaStatement($lineId, $creativeId);
        $page = $licaService->getLineItemCreativeAssociationsByStatement($statementBuilder->ToStatement());
        $lica = $page->results[0];
        $this->setOptions($lica, $options);
        $licaService->updateLineItemCreativeAssociations(array($lica));
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
        if ($this->enableLogs) {
            $user->LogDefaults();
        }
        return $user;
    }
}