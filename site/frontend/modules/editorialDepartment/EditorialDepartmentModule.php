<?php

namespace site\frontend\modules\editorialDepartment;

/**
 * Description of EditorialDepartmentModule
 *
 * @author Кирилл
 */
class EditorialDepartmentModule extends \CWebModule
{

    public $controllerNamespace = 'site\frontend\modules\editorialDepartment\controllers';

    public function init()
    {
        if (!\Yii::app()->user->checkAccess('advEditor'))
            throw new \CHttpException(403);

        \CHtml::setModelNameConverter(function ($model)
            {
                return substr(strrchr(get_class($model), '\\'), 1);
            });

        parent::init();
    }

    public function beforeControllerAction($controller, $action)
    {
        \Yii::app()->clientScript->registerPackage('lite_editorial-department_user');
        \Yii::app()->clientScript->useAMD = true;
        return parent::beforeControllerAction($controller, $action);
    }

}

?>
