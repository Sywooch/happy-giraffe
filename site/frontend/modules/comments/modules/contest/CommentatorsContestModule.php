<?php
namespace site\frontend\modules\comments\modules\contest;

/**
 * @author Никита
 * @date 20/02/15
 */

class CommentatorsContestModule extends \CWebModule
{
    public $controllerNamespace = 'site\frontend\modules\comments\modules\contest\controllers';

    public function beforeControllerAction($controller, $action)
    {
        if (! \Yii::app()->serviceStatus->isActive('commentatorsContest')) {
            \Yii::app()->controller->redirect('/');
        }

        return parent::beforeControllerAction($controller, $action);
    }
}