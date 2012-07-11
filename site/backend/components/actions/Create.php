<?php

class Create extends CAction
{
    private $_model;

    public function run()
    {
        $controller = $this->getController();
        $model = new $controller->_class('create');
        $this->_model = $model;

        $controller->performAjaxValidation($model);

        if (isset($_GET[$controller->_class])) {
            $model->attributes = $_GET[$controller->_class];
        }

        if (isset($_POST[$controller->_class])) {
            $model->attributes = $_POST[$controller->_class];

            if ($model->save()) {
                if (method_exists($controller, 'onCreateAfterSave')) {
                    $controller->onCreateAfterSave(get_defined_vars());
                } else {
                    $this->afterSave();
                }
            }
        }

        if (method_exists($controller, 'onCreateBeforeRender')) {
            $controller->onCreateBeforeRender(get_defined_vars());
        }

        $controller->render('create', array(
            'model' => $model,
        ));
    }

    protected function afterSave()
    {
        $controller = $this->getController();

        $redirect_to = 'admin';
        if (!empty($_POST['redirect_to'])) {
            if ($_POST['redirect_to'] == 'refresh') {
                $this->_model->refresh();
                $controller->redirect($controller->createUrl('update', array('id' => $this->_model->id)));
            } else {
                $redirect_to = $_POST['redirect_to'];
            }
        }
        $controller->redirect(array($redirect_to));
    }
}
