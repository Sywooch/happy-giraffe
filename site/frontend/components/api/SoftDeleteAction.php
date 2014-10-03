<?php

namespace site\frontend\components\api;

/**
 * Description of SoftDeleteAction
 *
 * @author Кирилл
 * @property \site\frontend\components\api\ApiController $controller
 */
class SoftDeleteAction extends ApiAction
{

    /**
     * @var string Класс модели для удаления
     */
    public $modelName = null;

    public function run($id)
    {
        $model = $this->controller->getModel($this->modelName, $id, $this->checkAccess);

        if ($model instanceof \IHToJSON)
            $this->controller->data = $model->toJSON();
        $this->controller->success = $model->softDelete();
    }

}

?>
