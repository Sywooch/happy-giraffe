<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 15/01/14
 * Time: 11:49
 * To change this template use File | Settings | File Templates.
 */

abstract class AntispamReportData extends HActiveRecord
{
    abstract public function getIconClass();
    abstract public function getAnalysisUrl();
}