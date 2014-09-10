<?php

namespace site\frontend\modules\comments\controllers;

/**
 * Контроллер для проверки комментариев
 *
 * @author Кирилл
 */
class DefaultController extends \HController
{
    
    public $layout = '//layouts/lite/main';

    public function actionIndex($entity, $entityId)
    {
        $model = $entity::model()->findByPk($entityId);
        if (!$model)
            throw new \CHttpException(404);

        $this->render('example', array('model' => $model));
    }

}

?>
