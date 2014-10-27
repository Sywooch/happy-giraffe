<?php

namespace site\frontend\modules\posts\controllers;

use site\frontend\modules\posts\components\PostController;
use site\frontend\components\api\models\User;

/**
 * Description of DefaultController
 *
 * @author Кирилл
 */
class DefaultController extends \LiteController
{
    public $litePackage = 'posts';

    public function actionIndex()
    {
        ob_start();

        $models = \CommunityContent::model()->findAll(array(
            'condition' => 'type_id = ' . \CommunityContent::TYPE_PHOTO_POST . ' AND author_id = 56',
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
