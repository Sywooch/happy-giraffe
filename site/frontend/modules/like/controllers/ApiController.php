<?php

namespace site\frontend\modules\like\controllers;

use site\frontend\modules\like\models\Like;

/**
 * Description of ApiController
 *
 * @todo Переписать ВСЁ!!!
 * @author Кирилл
 */
class ApiController extends \site\frontend\components\api\ApiController
{

    public function filters()
    {
        return \CMap::mergeArray(parent::filters(), array(
                'accessControl',
        ));
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('get'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('add', 'del'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actions()
    {
        return \CMap::mergeArray(parent::actions(), array(
                'get' => 'site\frontend\components\api\PackAction',
        ));
    }

    public function packGet(array $id)
    {
        $this->success = true;
        /** @todo Переписать модель и её использование */
        $this->data = array(
            'id' => $id,
            'count' => Like::model()->countByEntity($id),
            'isLiked' => \Yii::app()->user->isGuest ? null : Like::model()->hasLike($id, \Yii::app()->user->id),
        );
    }

    public function actionAdd(array $id)
    {
        /** @todo Т.к. у модели нет интерфейса лайк/дислайк, а есть только переключение состояния, то лайк и дислайк реализуются одинакого */
        $entity_id = $id['entityId'];
        $entity = $id['entity'];

        /** @todo Убрать resetScope. Было написано для случаев со статусами и CommunityContent */
        $model = $entity::model()->resetScope()->findByPk($entity_id);
        if ($model) {
            throw new \CHttpException(404);
        }

        if ($model->author_id != \Yii::app()->user->id) {
            Like::model()->saveByEntity($model);
            $this->success = true;

            /* На самом деле, рейтинг пересчитывается в HGLike::saveByEntity */
            //PostRating::reCalc($model);

            /** @todo Переписать модель и её использование */
            $this->data = array(
                'id' => $id,
                'count' => Like::model()->countByEntity($id),
                'isLiked' => \Yii::app()->user->isGuest ? null : Like::model()->hasLike($id, \Yii::app()->user->id),
            );
        }
        else {
            $this->success = false;
            $this->errorMessage = 'Автор не может лайкать свой контент';
        }
    }

    public function actionDel(array $id)
    {
        /** @todo Т.к. у модели нет интерфейса лайк/дислайк, а есть только переключение состояния, то лайк и дислайк реализуются одинакого */
        $entity_id = $id['entityId'];
        $entity = $id['entity'];

        /** @todo Убрать resetScope. Было написано для случаев со статусами и CommunityContent */
        $model = $entity::model()->resetScope()->findByPk($entity_id);
        if ($model) {
            throw new \CHttpException(404);
        }

        if ($model->author_id != \Yii::app()->user->id) {
            Like::model()->saveByEntity($model);
            $this->success = true;

            /* На самом деле, рейтинг пересчитывается в HGLike::saveByEntity */
            //PostRating::reCalc($model);

            /** @todo Переписать модель и её использование */
            $this->data = array(
                'id' => $id,
                'count' => Like::countByEntity($id),
                'isLiked' => \Yii::app()->user->isGuest ? null : Like::model()->hasLike($id, \Yii::app()->user->id),
            );
        }
        else {
            $this->success = false;
            $this->errorMessage = 'Автор не может лайкать свой контент';
        }
    }

}

?>
