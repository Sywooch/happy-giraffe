<?php

namespace site\frontend\modules\posts\components;

/**
 * Description of PostController
 *
 * @author Кирилл
 */
class PostController extends \LiteController
{

    public $litePackage = 'posts';

    public function beforeAction($action)
    {
        if ($this->litePackage)
        {
            $package = \Yii::app()->user->isGuest ? 'lite_' . $this->litePackage : 'lite_' . $this->litePackage . '_user';
            \Yii::app()->clientScript->registerPackage($package);
            \Yii::app()->clientScript->useAMD = true;
        }
        return parent::beforeAction($action);
    }

}

?>
