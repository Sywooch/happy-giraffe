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
        $this->controller->success = $model->delete();
    }

}

?>
