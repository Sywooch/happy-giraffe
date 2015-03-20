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
        if (isset($request['originManageInfo'])) {
            $post->originManageInfoObject->fromJSON($request['originManageInfo']);
        }
        if (isset($request['meta'])) {
            $post->metaObject->fromJSON($request['meta']);
        }
        if (isset($request['social'])) {
            $post->socialObject->fromJSON($request['social']);
        }
        if (isset($request['template'])) {
            $post->templateObject->fromJSON($request['template']);
        }
        if (isset($request['labels'])) {
            $post->labelsArray = $request['labels'];
        }
        if ($post->save()) {
            $post->refresh();
            $this->success = true;
            $this->data = $post->toJSON();
        } else {
            $this->errorCode = 1;
            $this->errorMessage = $post->getErrors();
        }
    }

}

?>
