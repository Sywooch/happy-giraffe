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
    public $check;

    public function run()
    {
        $statuses = array(
            'UNDEFINED' => AntispamCheck::STATUS_UNDEFINED,
            'GOOD' => AntispamCheck::STATUS_GOOD,
            'BAD' => AntispamCheck::STATUS_BAD,
            'PENDING' => AntispamCheck::STATUS_PENDING,
            'QUESTIONABLE' => AntispamCheck::STATUS_QUESTIONABLE,
        );

        $this->render('MarkWidget', compact('statuses'));
    }
}