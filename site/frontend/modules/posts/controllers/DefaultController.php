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

        
        $model = \CommunityContent::model()->findByPk(120070);    
        $model->addTaskToConvert();
            
        $text = ob_get_clean();
        $this->renderText('<pre>' . htmlspecialchars($text) . '</pre>');
    }

}

?>
