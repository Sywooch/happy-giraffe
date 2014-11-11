<?php

namespace site\frontend\modules\posts\controllers;

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

        
        $model = \CommunityContent::model()->findByPk(120418);    
        $model->addTaskToConvert();
            
        $text = ob_get_clean();
        $this->renderText('<pre>' . htmlspecialchars($text) . '</pre>');
    }

}

?>
