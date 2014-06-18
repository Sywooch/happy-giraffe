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
    public $roles = array('commentator', 'tester');

    public function afterSave($event)
    {
        $toAdd = false;

        foreach ($this->roles as $role) {
            if (\Yii::app()->user->checkAccess($role)) {
                $toAdd = true;
                break;
            }
        }

        if ($this->owner->isNewRecord && $toAdd) {
            $data = SeoYandexOriginalText::getAttributesByModel($this->owner);
            \Yii::app()->gearman->client()->doBackground('processOriginalText', serialize($data));
        }

        return parent::afterSave($event);
    }
} 