<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 20/01/14
 * Time: 18:08
 * To change this template use File | Settings | File Templates.
 */

class ReportController extends HController
{
    public function actionMark()
    {
        $reportId = Yii::app()->request->getPost('reportId');
        $report = AntispamReport::model()->findByPk($reportId);
        $report->status = AntispamReport::STATUS_CONSIDERED;
        $report->moderator_id = Yii::app()->user->id;
        $report->update(array('status', 'moderator_id', 'updated'));
    }
}