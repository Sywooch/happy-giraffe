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
        $data = array(
            'entity' => get_class($this->owner),
            'entity_id' => $this->owner->id,
            'text' => $this->owner->text,
        );

        \Yii::app()->gearman->client()->doBackground('processOriginalText', serialize($data));

        return parent::afterSave($event);
    }
} 