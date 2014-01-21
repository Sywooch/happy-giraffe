<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 17/01/14
 * Time: 13:37
 * To change this template use File | Settings | File Templates.
 */

class MarkWidget extends CWidget
{
    /**
     * @var AntispamCheck $check
     */
    public $check;
    public $analysisMode;

    public function run()
    {
        $statuses = array(
            'UNDEFINED' => AntispamCheck::STATUS_UNDEFINED,
            'GOOD' => AntispamCheck::STATUS_GOOD,
            'BAD' => AntispamCheck::STATUS_BAD,
            'PENDING' => AntispamCheck::STATUS_PENDING,
            'QUESTIONABLE' => AntispamCheck::STATUS_QUESTIONABLE,
        );
        $domId = $this->getDomId();

        $json = array(
            'statuses' => $statuses,
            'check' => $this->check->toJson(),
        );

        $this->render('MarkWidget', compact('json', 'domId'));
    }

    protected function getDomId()
    {
        return md5($this->check->id . __CLASS__);
    }
}