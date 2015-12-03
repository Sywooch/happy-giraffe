<?php
/**
 * @author Никита
 * @date 12/11/15
 */

namespace site\frontend\modules\som\modules\qa\controllers;


use site\frontend\modules\som\modules\qa\components\QaController;
use site\frontend\modules\som\modules\qa\models\QaConsultation;
use site\frontend\modules\som\modules\qa\models\QaQuestion;

class ConsultationController extends QaController
{
    public $litePackage = 'faq';
    public $layout = '/layouts/consultation';

    public function actionIndex($consultationId)
    {
        $consultation = QaConsultation::model()->findByPk($consultationId);

        $model = clone QaQuestion::model();
        $model->consultation($consultationId);
        $dp = new \CActiveDataProvider($model, array(
            'pagination' => array(
                'pageVar' => 'page',
            ),
        ));
        $this->render('index', compact('consultation', 'dp'));
    }
}