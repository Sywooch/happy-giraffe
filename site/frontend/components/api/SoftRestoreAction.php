<?php

namespace site\frontend\components\api;

/**
 * Description of SoftRestoreAction
 *
 * @author Кирилл
 * @property \site\frontend\components\api\ApiController $controller
 */
class SoftRestoreAction extends ApiAction
{

    public function run($id)
    {
        $model = $this->controller->getModel($this->modelName, $id, $this->checkAccess, true);

        $this->controller->success = $model->restore();
        if ($model instanceof \IHToJSON)
            $this->controller->data = $model->toJSON();
    }

}

?>
