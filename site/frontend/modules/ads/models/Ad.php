<?php
namespace site\frontend\modules\ads\models;

/**
 * @property int $id
 * @property string $entity
 * @property string $entityId
 * @property string $preset
 * @property string $properties
 * @property string $lineId
 * @property string $creativeId
 * @property bool $active
 * @property int $dtimeCreate
 * @property int $dtimeUpdate
 *
 * @author Никита
 * @date 05/02/15
 */

class Ad extends \HActiveRecord
{
    public function tableName()
    {
        return 'ads';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function behaviors()
    {
        return array(
            'HTimestampBehavior' => array(
                'class' => 'HTimestampBehavior',
                'createAttribute' => 'dtimeCreate',
                'updateAttribute' => 'dtimeUpdate',
                'setUpdateOnCreate' => true,
            ),
        );
    }

    public function line($lineId)
    {
        $this->getDbCriteria()->compare('t.lineId', $lineId);
        return $this;
    }

    public function template($templateId)
    {
        $this->getDbCriteria()->compare('t.templateId', $templateId);
        return $this;
    }

    public function entity(\CActiveRecord $model)
    {
        $this->getDbCriteria()->compare('t.entity', get_class($model));
        $this->getDbCriteria()->compare('t.entityId', $model->id);
        return $this;
    }
}