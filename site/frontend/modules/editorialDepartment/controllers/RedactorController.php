<?php

namespace site\frontend\modules\editorialDepartment\controllers;

use \site\frontend\modules\editorialDepartment\models as departmentModels;

/**
 * Description of RedactorController
 *
 * @author Кирилл
 */
class RedactorController extends \LiteController
{

    public function actionIndex($forumId)
    {
        $model = new departmentModels\Content();
        $model->authorId = \Yii::app()->user->id;
        $model->forumId = $forumId;
        $model->clubId = \Community::model()->findByPk($forumId)->club_id;

        if (isset($_POST['Content']))
        {
            $model->setAttributes($_POST['Content'], false);
            if ($model->save())
                $this->redirect(array('edit', 'entity' => $model->entity, 'entityId' => $model->entityId));
        }

        $this->render('index', array('model' => $model));
    }

    public function actionEdit($entity, $entityId)
    {
        $model = $this->getModel($entity, $entityId);
        if (isset($_POST['Content']))
        {
            $model->setAttributes($_POST['Content'], false);
            if ($model->save())
                $this->refresh();
        }
        
        $this->render('index', array('model' => $model));
    }
    
    public function actionUrlForEdit($entity = 'CommunityContent', $entityId)
    {
        $this->getModel($entity, $entityId);
        echo \CJSON::encode(array('url' => $this->createUrl('edit', array('entity' => $entity, 'entityId' => $entityId))));
    }
    
    protected function getModel($entity, $entityId)
    {
        $entityId = (int) $entityId;
        $model = departmentModels\Content::model()->findByAttributes(compact('entity', 'entityId'));
        if (is_null($model))
            throw new \CHttpException(404);
        if ($model->authorId != \Yii::app()->user->id)
            throw new \CHttpException(403);
        
        return $model;
    }

}

?>
