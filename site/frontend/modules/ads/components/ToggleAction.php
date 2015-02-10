<?php
/**
 * @author Никита
 * @date 10/02/15
 */

namespace site\frontend\modules\ads\components;


class ToggleAction extends \CAction
{
    public $modelClass;

    public function run($id, $preset, $line, array $properties = array())
    {
        $model = \CActiveRecord::model($this->modelClass, $preset);
        $properties['model'] = $model;
        $creative = \Yii::app()->getModule('ads')->creativesFactory->create($preset, $properties);
        \Yii::app()->getModule('ads')->manager->toggle($creative, $line);
    }
}