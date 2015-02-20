<?php
/**
 * @author Никита
 * @date 20/02/15
 */

class ContestBehavior extends CActiveRecordBehavior
{
    public function afterSave()
    {
        \Yii::app()->gearman->client()->doBackground('processUrl', $url, md5($url));
    }
}