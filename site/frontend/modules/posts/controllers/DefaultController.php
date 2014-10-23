<?php

namespace site\frontend\modules\posts\controllers;

use site\frontend\modules\posts\components\PostController;
use site\frontend\components\api\models\User;

/**
 * Description of DefaultController
 *
 * @author Кирилл
 */
class DefaultController extends PostController
{

    public function actionIndex()
    {
        ob_start();

        $models = \CommunityContent::model()->findAll(array(
            'condition' => 'type_id = ' . \CommunityContent::TYPE_POST,
            'limit' => 1000,
            'order' => 'RAND()',
        ));
        foreach ($models as $model)
        {
            $model->addTaskToConvert();
        }
        $text = ob_get_clean();
        $this->renderText('<pre>' . htmlspecialchars($text) . '</pre>');
    }

}

?>
