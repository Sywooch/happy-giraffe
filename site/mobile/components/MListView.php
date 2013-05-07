<?php
Yii::import('zii.widgets.CListView');

class MListView extends CListView
{
    public $baseScriptUrl = null;
    public $cssFile = false;
    public $summaryText = '';
    public $emptyText = '';

    public function run()
    {
        echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";

        $this->renderContent();
        $this->renderKeys();

        echo CHtml::closeTag($this->tagName);
    }
}