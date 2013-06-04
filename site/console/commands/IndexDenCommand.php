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
        $posts = CommunityContent::model()->full()->findAll('rubric.community_id = :community_id', array(':community_id' => 9));
        foreach ($posts as $m)
            $m->searchable->save();

        $photos = AlbumPhoto::model()->findAllByAttributes(array('author_id' => 12936));
        foreach ($photos as $m)
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