<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 5/31/13
 * Time: 10:36 AM
 * To change this template use File | Settings | File Templates.
 */

class IndexDenCommand extends CConsoleCommand
{
    public function actionIndex()
    {
        $models = CommunityContent::model()->full()->findAll('rubric.community_id = :community_id', array(':community_id' => 9));
        foreach ($models as $m)
            $m->searchable->save();
    }

    public function actionDaemon()
    {
        Yii::app()->gearman->worker()->addFunction('indexden', array($this, "processMessage"));
        while (Yii::app()->gearman->worker()->work()) ;
    }

    public function processMessage($job)
    {
        $data = unserialize($job->workload());
        var_dump($data);
        extract($data);
        switch ($modelName) {
            case 'BlogContent':
            case 'CommunityContent':
                $model = CActiveRecord::model($modelName)->resetScope()->full()->findByPk($modelId);
                break;
            default:
                $model = CActiveRecord::model($modelName)->resetScope()->findByPk($modelId);
        }
        $model->searchable->$action();
    }
}