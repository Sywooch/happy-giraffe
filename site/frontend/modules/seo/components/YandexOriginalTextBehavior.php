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
    public function afterSave($event)
    {
        if ($this->owner->author->group != \UserGroup::USER) {
            $data = SeoYandexOriginalText::getAttributesByModel($this->owner);
            \Yii::app()->gearman->client()->doBackground('processOriginalText', serialize($data));
        }

        return parent::afterSave($event);
    }
} 