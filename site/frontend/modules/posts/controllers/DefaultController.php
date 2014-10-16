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
        var_dump(User::model()->findByPk(83)->attributes);
        $text = ob_get_clean();
        $this->renderText('<pre>' . htmlspecialchars($text) . '</pre>');
    }

}

?>
