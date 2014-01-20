<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 17/01/14
 * Time: 17:22
 * To change this template use File | Settings | File Templates.
 */

class UserMarkWidget extends CWidget
{
    public $status;
    public $extended;

    public function run()
    {
        $statuses = array(
            'UNDEFINED' => AntispamStatusManager::STATUS_UNDEFINED,
            'WHITE' => AntispamStatusManager::STATUS_WHITE,
            'GRAY' => AntispamStatusManager::STATUS_GRAY,
            'BLACK' => AntispamStatusManager::STATUS_BLACK,
            'BLOCKED' => AntispamStatusManager::STATUS_BLOCKED,
        );
        $domId = $this->getDomId();

        $json = array(
            'status' => $this->status->toJson(),
            'statuses' => $statuses,
        );

        $this->render('UserMarkWidget', compact('json', 'domId'));
    }

    protected function getDomId()
    {
        return md5($this->status->id . __CLASS__);
    }
}