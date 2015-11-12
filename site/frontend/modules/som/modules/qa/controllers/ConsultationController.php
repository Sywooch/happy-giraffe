<?php
/**
 * @author Никита
 * @date 12/11/15
 */

namespace site\frontend\modules\som\modules\qa\controllers;


use site\frontend\modules\som\modules\qa\models\QaQuestion;

class ConsultationController extends \LiteController
{
    public $litePackage = 'faq';
    public $layout = '/layouts/consultation';

    public function actionIndex($consultationId)
    {
        $model = QaQuestion::model()->consultation($consultationId);
        $dp = new \CActiveDataProvider($model, array(
            'pagination' => array(
                'pageVar' => 'page',
            ),
        ));
        $this->render('index', compact('dp'));
    }
}