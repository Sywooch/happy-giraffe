<?php

namespace site\frontend\components\api;

/**
 * Description of SoftDeleteAction
 *
 * @author Кирилл
 * @property \site\frontend\components\api\ApiController $controller
 */
class SoftDeleteAction extends \CAction
{

    /**
     * @var string Класс модели для удаления
     */
    public $modelName = null;

    public function run($id)
    {
        /** @todo Проверить доступ */
        $class = $this->modelName;
        $model = $class::model()->findByPk($id);
        if (is_null($model))
            throw new \CHttpException(404);

        if ($model instanceof \IHToJSON)
            $this->controller->data = $model->toJSON();
        $this->controller->success = $model->softDelete();
    }

}

?>
