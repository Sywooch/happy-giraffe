<?php

namespace site\frontend\modules\questionnaire;

class QuestionnaireModule extends \CWebModule
{
    public function init()
    {
        if (!\Yii::app()->user->checkAccess('advEditor')){
            throw new \CHttpException(403);
        }

        $this->setImport(array(
            'questionnaire.models.*'
        ));
    }

    public function beforeControllerAction($controller, $action)
    {
        if(parent::beforeControllerAction($controller, $action))
        {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        }
        else
            return false;
    }
}