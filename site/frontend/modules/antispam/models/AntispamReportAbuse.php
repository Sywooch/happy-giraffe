<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 07/02/14
 * Time: 16:52
 * To change this template use File | Settings | File Templates.
 */

class AntispamReportAbuse extends AntispamReport
{
    public function relations()
    {
        return CMap::mergeArray(parent::relations(), array(
            'data' => array(self::HAS_ONE, 'AntispamReportAbuseData', 'report_id'),
        ));
    }
}