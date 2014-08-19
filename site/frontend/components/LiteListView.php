<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 31/07/14
 * Time: 12:10
 */

Yii::import('zii.widgets.CListView');

class LiteListView extends CListView
{
    public $ajaxUpdate = false;
    public $cssFile = false;
    public $template = '{items}<div class="yiipagination">{pager}</div>';
    public $itemsTagName = 'ul';
    public $pager = array(
        'class' => 'LitePager',
    );

    public function registerClientScript()
    {
        $id=$this->getId();

        if($this->ajaxUpdate===false)
            $ajaxUpdate=array();
        else
            $ajaxUpdate=array_unique(preg_split('/\s*,\s*/',$this->ajaxUpdate.','.$id,-1,PREG_SPLIT_NO_EMPTY));
        $options=array(
            'ajaxUpdate'=>$ajaxUpdate,
            'ajaxVar'=>$this->ajaxVar,
            'pagerClass'=>$this->pagerCssClass,
            'loadingClass'=>$this->loadingCssClass,
            'sorterClass'=>$this->sorterCssClass,
            'enableHistory'=>$this->enableHistory
        );
        if($this->ajaxUrl!==null)
            $options['url']=CHtml::normalizeUrl($this->ajaxUrl);
        if($this->ajaxType!==null)
            $options['ajaxType']=strtoupper($this->ajaxType);
        if($this->updateSelector!==null)
            $options['updateSelector']=$this->updateSelector;
        foreach(array('beforeAjaxUpdate', 'afterAjaxUpdate', 'ajaxUpdateError') as $event)
        {
            if($this->$event!==null)
            {
                if($this->$event instanceof CJavaScriptExpression)
                    $options[$event]=$this->$event;
                else
                    $options[$event]=new CJavaScriptExpression($this->$event);
            }
        }
    }
} 