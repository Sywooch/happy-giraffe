<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 5/20/13
 * Time: 1:45 PM
 * To change this template use File | Settings | File Templates.
 */

class AlbumsController extends MController
{
    public function actionSinglePhoto($entity, $photo_id)
    {
        $photo = AlbumPhoto::model()->findByPk($photo_id);
        if ($photo === null)
            throw new CHttpException(404, 'Фото не найдено');

        Yii::import('site.frontend.modules.contest.models.*');
        $contest_id = Yii::app()->request->getQuery('contest_id');
        $model = CActiveRecord::model($entity)->findByPk($contest_id);
        $attach = $photo->getAttachByEntity('ContestWork', $photo_id);
        if (!isset($attach->model))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $work = $attach->model;
        if ($work === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        $photo->w_title = $work->title;
        $this->pageTitle = $work->title . ' - ' . $model->title;

        $sql = "
            SELECT position
            FROM
            (
              SELECT id, @rownum := @rownum + 1 AS position
              FROM contest__works w
              JOIN (SELECT @rownum := 0) r
              WHERE contest_id = 9
              ORDER BY id DESC
            ) x
            WHERE id = :work_id;
        ";
        $currentIndex = Yii::app()->db->createCommand($sql)->queryScalar(array(':work_id' => $work->id));
        $prev = ContestWork::model()->find(array(
            'condition' => 'contest_id = :contest_id AND id > :current_id',
            'params' => array(':contest_id' => $model->id, ':current_id' => $work->id),
            'order' => 'id ASC'
        ));
        $next = ContestWork::model()->find(array(
            'condition' => 'contest_id = :contest_id AND id < :current_id',
            'params' => array(':contest_id' => $model->id, ':current_id' => $work->id),
            'order' => 'id DESC'
        ));

        $this->render('singlePhoto', compact('photo', 'model', 'currentIndex', 'prev', 'next'));
    }
}