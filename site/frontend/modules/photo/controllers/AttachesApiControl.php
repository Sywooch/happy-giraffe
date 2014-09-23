<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 23/09/14
 * Time: 16:43
 */

namespace site\frontend\modules\photo\controllers;


use site\frontend\components\api\ApiController;

class AttachesApiController extends ApiController
{
    public function actions()
    {
        return \CMap::mergeArray(parent::actions(), array(
            'remove' => array(
                'class' => 'site\frontend\components\api\SoftDeleteAction',
                'modelName' => '\site\frontend\modules\photo\models\PhotoAttach',
            ),
            'restore' => array(
                'class' => 'site\frontend\components\api\SoftRestoreAction',
                'modelName' => '\site\frontend\modules\photo\models\PhotoAttach',
            ),
        ));
    }
} 