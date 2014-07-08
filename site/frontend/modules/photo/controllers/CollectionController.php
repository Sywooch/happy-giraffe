<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 30/05/14
 * Time: 10:38
 */

namespace site\frontend\modules\photo\controllers;

use site\frontend\modules\photo\models\PhotoAttach;

class CollectionController extends \HController
{
    public function filters() {
        return array(
            'ajaxOnly + getAttaches',
        );
    }

    /**
     * Загрузка аттачей коллекции
     *
     * @param $collectionId
     */
    public function actionGetAttaches($collectionId)
    {
        $photos = PhotoAttach::model()->collection($collectionId)->findAll();
        echo \HJSON::encode($photos);
    }
} 