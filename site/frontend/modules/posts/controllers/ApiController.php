<?php

namespace site\frontend\modules\posts\controllers;

use site\frontend\modules\posts as posts;

/**
 * Description of ApiController
 *
 * @author Кирилл
 */
class ApiController extends \site\frontend\components\api\ApiController
{

    public function actionCreate()
    {
        $request = $this->getActionParams();
        $post = new posts\models\Content($request['scenario']);
        $post->setAttributes($request);
        if ($post->save())
        {
            $post->refresh();
            $this->success = true;
            $this->data = $post->toJSON();
        }
        else
        {
            $this->errorCode = 1;
            $this->errorMessage = $post->getErrors();
        }
    }

}

?>
