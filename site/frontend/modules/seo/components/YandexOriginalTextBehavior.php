<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 04/06/14
 * Time: 10:00
 */

namespace site\frontend\modules\seo\components;


use site\frontend\modules\seo\models\SeoYandexOriginalText;

class YandexOriginalTextBehavior extends \CActiveRecordBehavior
{
    const MIN_SYMBOLS = 500;
    const MAX_SYMBOLS = 32000;

    protected function afterSave($event)
    {
        $data = SeoYandexOriginalText::getAttributesByModel($this->owner);

        \Yii::app()->gearman->client()->doBackground('processOriginalText', serialize($data));

        return parent::afterSave($event);
    }
} 