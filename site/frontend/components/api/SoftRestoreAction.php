<?php

namespace site\frontend\components\api;

/**
 * Description of SoftRestoreAction
 *
 * @author Кирилл
 * @property \site\frontend\components\api\ApiController $controller
 */
class SoftRestoreAction extends \CAction
{

    /**
     * @var string Класс модели для удаления
     */
    public $modelName = null;

    public function run($id)
    {
        /** @todo Проверить доступ */
        $class = $this->modelName;
        $model = $class::model()->resetScope(true)->findByPk($id);
        if (is_null($model))
            throw new \CHttpException(404);

        if ($model instanceof \IHToJSON)
            $this->controller->data = $model->toJSON();
        $this->controller->success = $model->restore();
    }

}

?>
