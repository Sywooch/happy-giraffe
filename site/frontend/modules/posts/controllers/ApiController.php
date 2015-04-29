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

    public static $model = 'site\frontend\modules\posts\models\Content';

    public function actions()
    {
        return \CMap::mergeArray(parent::actions(), array(
                    'get' => 'site\frontend\components\api\PackAction',
        ));
    }

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

    public function packGet($id)
    {
        $post = $this->getModel(self::$model, $id, false);
        $this->success = true;
        $this->data = $post->toJSON();
    }

    public function actionGetByAttributes($entityId, $entity)
    {
        $post = posts\models\Content::model()->findByAttributes(array(
            'originEntityId' => $entityId,
            'originEntity' => $entity,
        ));
        if ($post) {
            $this->success = true;
            $this->data = $post->toJSON();
        } else {
            throw new \CHttpException(404);
        }
    }

    public function actionUpdate($id)
    {
        $request = $this->getActionParams();
        $post = $this->getModel(self::$model, $id, false);
        if (isset($request['originManageInfo'])) {
            $post->originManageInfoObject->fromJSON($request['originManageInfo']);
            unset($request['originManageInfo']);
        }
        if (isset($request['meta'])) {
            $post->metaObject->fromJSON($request['meta']);
            unset($request['meta']);
        }
        if (isset($request['social'])) {
            $post->socialObject->fromJSON($request['social']);
            unset($request['social']);
        }
        if (isset($request['template'])) {
            $post->templateObject->fromJSON($request['template']);
            unset($request['template']);
        }
        if (isset($request['labels'])) {
            $post->labelsArray = $request['labels'];
            unset($request['labels']);
        }
        $post->setAttributes($request, false);
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
