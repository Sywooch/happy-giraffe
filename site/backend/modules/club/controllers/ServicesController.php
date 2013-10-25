<?php

class ServicesController extends BController
{
    public $defaultAction = 'admin';
    public $section = 'club';
    public $layout = '//layouts/club';
    public $_class = 'Service';
    public $authItem = 'services';

    public function actions()
    {
        return array(
            'create' => 'application.components.actions.Create',
            //'update' => 'application.components.actions.Update',
            'delete' => 'application.components.actions.Delete',
            'admin' => 'application.components.actions.Admin',
            'addPhoto' => 'application.components.actions.UploadPhoto'
        );
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        $model->setScenario('update');

        if (isset($_POST[$this->_class])) {
            $model->attributes = $_POST[$this->_class];
            $communities = array();
            if (isset($_POST[$this->_class]['communities'])){
                foreach ($_POST[$this->_class]['communities'] as $community_id => $val)
                    if ($val)
                        $communities [] = Community::model()->findByPk($community_id);
            } else
                $communities = array();

            Yii::app()->db->createCommand()->delete('services__communities', 'service_id = '.$model->id);
            $model->communities = $communities;

            if ($model->validate() && $model->withRelated->save(false, array('communities'))) {
                $redirect_to = 'admin';
                if (!empty($_POST['redirect_to'])) {
                    if ($_POST['redirect_to'] == 'refresh') {
                        $this->refresh();
                    } else {
                        $redirect_to = $_POST['redirect_to'];
                    }
                }
                $this->redirect(array($redirect_to));
            }else{
                var_dump($model->getErrors());
                foreach($model->communities as $c)
                    var_dump($c->getErrors());
                Yii::app()->end();
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }
}
