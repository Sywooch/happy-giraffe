<?php

namespace site\frontend\components\api;

/**
 * Description of ApiAction
 *
 * @author Кирилл
 * @property ApiController $controller The controller who owns this action.
 */
class ApiAction extends \CAction
{

    /**
     * @var string Класс модели для удаления
     */
    public $modelName = null;

    /**
     * @var string|bool Роль/задача/операция, для проверки (модель в бизнес правила передаётся в параметре entity). Если false, то модель не проверяется, если true, то будет проверка на наличие модели.
     */
    public $checkAccess = false;

}

?>
