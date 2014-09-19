<?php

namespace site\frontend\modules\comments\controllers;

/**
 * Description of ApiController
 *
 * @author Кирилл
 */
class ApiController extends \site\frontend\components\api\ApiController
{

    public function actions()
    {
        return \CMap::mergeArray(parent::actions(), array(
                'get' => 'site\frontend\components\api\PackAction',
                'remove' => array(
                    'class' => 'site\frontend\components\api\SoftDeleteAction',
                    'modelName' => '\site\frontend\modules\comments\models\Comment',
                ),
                'restore' => array(
                    'class' => 'site\frontend\components\api\SoftRestoreAction',
                    'modelName' => '\site\frontend\modules\comments\models\Comment',
                ),
        ));
    }

    public function packGet($id)
    {
        $comment = \site\frontend\modules\comments\models\Comment::model()->findByPk($id);
        if (!$comment)
            throw new \CHttpException(404, 'Комментарий ' . $id . ' не найден');
        $this->success = true;
        $this->data = $comment->toJSON();
    }

    public function actionCreate()
    {
        
    }

    public function actionUpdate()
    {
        
    }

    public function actionList($entity, $entityId, $listType = 'list', $rootCount = false, $dtimeFrom = 0)
    {
        $model = \site\frontend\modules\comments\models\Comment::model()->specialSort();
        $model->byEntity(array('entity' => $entity, 'entity_id' => $entityId));
        if ($dtimeFrom)
            $model->dtimeFrom($dtimeFrom);
        if ($rootCount && $listType)
            $model->rootLimit($rootCount, $listType);

        $models = $model->findAll();

        $this->data['list'] = array_map(function($item)
            {
                return $item->toJSON();
            }, $models);
        $this->data['isLast'] = false;
        $this->success = true;
    }

}

?>
