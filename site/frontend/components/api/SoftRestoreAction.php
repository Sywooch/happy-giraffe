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

    public function run()
    {
        /** @todo Проверить доступ */
        $class = $this->modelName;
        $model = $class::model()->findByPk();
        $this->controller->success = $model->restore();
    }

}

?>
