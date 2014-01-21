<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 15/01/14
 * Time: 11:53
 * To change this template use File | Settings | File Templates.
 */

class AntispamReportLimit extends AntispamReport
{
    public function relations()
    {
        return CMap::mergeArray(parent::relations(), array(
            'data' => array(self::HAS_ONE, 'AntispamReportLimitData', 'report_id'),
        ));
    }
}