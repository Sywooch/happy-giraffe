<?php

class Update extends CAction
{
    public function run()
    {
        $controller = $this->getController();
        $params = $controller->getActionParams();
        $model = $controller->loadModel($params['id']);
        $model->setScenario('update');

        if (isset($_POST[$controller->_class])) {
            $model->attributes = $_POST[$controller->_class];
            //$controller->performUploads($model);
            if ($model->save()) {
                //$controller->setFlash('success', 'Запись успешно обновлена');
                //$controller->performUploadsSaveToDisk($model);

                if (method_exists($controller, 'onUpdateAfterSave')) {
                    $controller->onUpdateAfterSave(get_defined_vars());
                } else {
                    $redirect_to = 'admin';
                    if (!empty($_POST['redirect_to'])) {
                        if ($_POST['redirect_to'] == 'refresh') {
                            $controller->refresh();
                        } else {
                            $redirect_to = $_POST['redirect_to'];
                        }
                    }
                    $controller->redirect(array($redirect_to));
                }
            }
        }

        if (method_exists($controller, 'onUpdateBeforeRender')) {
            $controller->onUpdateBeforeRender(get_defined_vars());
        }

        $controller->render('update', array(
            'model' => $model,
        ));
    }
}
