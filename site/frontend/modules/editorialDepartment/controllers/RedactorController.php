<?php

namespace site\frontend\modules\editorialDepartment\controllers;

use \site\frontend\modules\editorialDepartment\models as departmentModels;
use site\frontend\modules\posts\models\Label;

/**
 * Description of RedactorController
 *
 * @author Кирилл
 */
class RedactorController extends \LiteController
{
    public function actionBuzz()
    {
        $model = new departmentModels\Content();
        $model->scenario = 'buzz';
        $model->authorId = \Yii::app()->user->id;
        $model->label = Label::LABEL_BUZZ;

        $formSendControl = \site\frontend\components\FormDepartmentModelsControl::getInstance();
        if (isset($_POST['Content']))
        {
            $formKey = $_POST['formKey'];
            if (($en = $formSendControl->getEntity($formKey)) != null)
            {
                $this->redirect(array('editBuzz', 'entity' => $en['entity'], 'entityId' => $en['entityId']));
            }
            $model->setAttributes($_POST['Content'], false);
            /**
             * @todo Сделать лучше, быстрее, сильнее
             */
            $model->htmlText = '<div class="b-markdown">' . $model->htmlText . '</div>';
            $model->htmlTextPreview = '<div class="b-markdown">' . $model->htmlTextPreview . '</div>';
            if ($model->save())
            {
                $formSendControl->setEntity($formKey, $model->entity, $model->entityId);
                $this->redirect(array('editBuzz', 'entity' => $model->entity, 'entityId' => $model->entityId));
            }
        }
        $formKey = $formSendControl->createNewFormKey();
        $this->render('buzz', array('model' => $model, 'formKey' => $formKey));
    }

    public function actionEditBuzz($entity, $entityId)
    {
        $model = $this->getModel($entity, $entityId);
        $model->scenario = 'buzz';
        if (isset($_POST['Content']))
        {
            $model->setAttributes($_POST['Content'], false);
            /**
             * @todo Сделать лучше, быстрее, сильнее
             */
            $model->htmlText = '<div class="b-markdown">' . $model->htmlText . '</div>';
            $model->htmlTextPreview = '<div class="b-markdown">' . $model->htmlTextPreview . '</div>';
            if ($model->save())
            {
                $this->refresh();
            }
        }

        $this->render('buzz', array('model' => $model, 'formKey' => null));
    }

    public function actionNews()
    {
        $model = new departmentModels\Content();
        $model->scenario = 'news';
        $model->authorId = \Yii::app()->user->id;
        $model->label = Label::LABEL_NEWS;

        $formSendControl = \site\frontend\components\FormDepartmentModelsControl::getInstance();
        if (isset($_POST['Content']))
        {
            $formKey = $_POST['formKey'];
            if (($en = $formSendControl->getEntity($formKey)) != null)
            {
                $this->redirect(array('editNews', 'entity' => $en['entity'], 'entityId' => $en['entityId']));
            }
            $model->setAttributes($_POST['Content'], false);
            /**
             * @todo Сделать лучше, быстрее, сильнее
             */
            $model->htmlText = '<div class="b-markdown">' . $model->htmlText . '</div>';
            $model->htmlTextPreview = '<div class="b-markdown">' . $model->htmlTextPreview . '</div>';
            if ($model->save())
            {
                $formSendControl->setEntity($formKey, $model->entity, $model->entityId);
                $this->redirect(array('editNews', 'entity' => $model->entity, 'entityId' => $model->entityId));
            }
        }
        $formKey = $formSendControl->createNewFormKey();
        $this->render('news', array('model' => $model, 'formKey' => $formKey));
    }

    public function actionEditNews($entity, $entityId)
    {
        $model = $this->getModel($entity, $entityId);
        $model->scenario = 'news';
        if (isset($_POST['Content']))
        {
            $model->setAttributes($_POST['Content'], false);
            /**
             * @todo Сделать лучше, быстрее, сильнее
             */
            $model->htmlText = '<div class="b-markdown">' . $model->htmlText . '</div>';
            $model->htmlTextPreview = '<div class="b-markdown">' . $model->htmlTextPreview . '</div>';
            if ($model->save())
            {
                $this->refresh();
            }
        }

        $this->render('news', array('model' => $model, 'formKey' => null));
    }

    public function actionBlog()
    {
        $model = new departmentModels\Content('blog');
        $model->authorId = \Yii::app()->user->id;

        $formSendControl = \site\frontend\components\FormDepartmentModelsControl::getInstance();
        if (isset($_POST['Content']))
        {
            $formKey = $_POST['formKey'];
            if (($en = $formSendControl->getEntity($formKey)) != null)
            {
                $this->redirect(array('editBlog', 'entity' => $en['entity'], 'entityId' => $en['entityId']));
            }
            $model->setAttributes($_POST['Content'], false);
            /**
             * @todo Сделать лучше, быстрее, сильнее
             */
            $model->htmlText = '<div class="b-markdown">' . $model->htmlText . '</div>';
            $model->htmlTextPreview = '<div class="b-markdown">' . $model->htmlTextPreview . '</div>';
            if ($model->save())
            {
                $formSendControl->setEntity($formKey, $model->entity, $model->entityId);
                $this->redirect(array('editBlog', 'entity' => $model->entity, 'entityId' => $model->entityId));
            }
        }
        $formKey = $formSendControl->createNewFormKey();
        $this->render('blog', array('model' => $model, 'formKey' => $formKey));
    }

    public function actionEditBlog($entity, $entityId)
    {
        $model = $this->getModel($entity, $entityId);
        $model->scenario = 'blog';
        if (isset($_POST['Content']))
        {
            $model->setAttributes($_POST['Content'], false);
            /**
             * @todo Сделать лучше, быстрее, сильнее
             */
            $model->htmlText = '<div class="b-markdown">' . $model->htmlText . '</div>';
            $model->htmlTextPreview = '<div class="b-markdown">' . $model->htmlTextPreview . '</div>';
            if ($model->save())
            {
                $this->refresh();
            }
        }

        $this->render('blog', array('model' => $model, 'formKey' => null));
    }

    public function actionUrlForEdit($entity = 'CommunityContent', $entityId)
    {
        $model = $this->getModel($entity, $entityId);
        echo \CJSON::encode(array('url' => $this->createUrl(($model->clubId ? 'edit' : 'editBlog'), array('entity' => $entity, 'entityId' => $entityId))));
    }

    /**
     * 
     * @param type $entity
     * @param type $entityId
     * @return \site\frontend\modules\editorialDepartment\models\Content
     * @throws \CHttpException
     */
    protected function getModel($entity, $entityId)
    {
        $entityId = (int) $entityId;
        $model = departmentModels\Content::model()->findByAttributes(compact('entity', 'entityId'));
        if (is_null($model))
            throw new \CHttpException(404);
        if ($model->authorId != \Yii::app()->user->id && ! in_array(\Yii::app()->user->id, array(455993, 175718, 15426, 186076, 183182, 401692, 20010))) // @todo с правами в этом модуле беда, пришлось захардкодить "супермодераторов"
            throw new \CHttpException(403);

        return $model;
    }

}

?>
