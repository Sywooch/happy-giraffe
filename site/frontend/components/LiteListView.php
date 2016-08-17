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
    public $emptyText = '';
    public $tab;
    public $category;

    /**
     * Renders the data item list.
     */
    public function renderItems()
    {
        if ($this->itemsTagName) {
            echo CHtml::openTag($this->itemsTagName, array('class' => $this->itemsCssClass)) . "\n";
        }
        $data = $this->dataProvider->getData();
        if (($n = count($data)) > 0) {
            $owner = $this->getOwner();
            $viewFile = $owner->getViewFile($this->itemView);
            $j = 0;
            foreach ($data as $i => $item) {
                $viewData = $this->viewData;
                $viewData['index'] = $i;
                $viewData['tab'] = $this->tab;
                $viewData['category'] = $this->category;
                $viewData['data'] = $item;
                $viewData['widget'] = $this;
                $owner->renderFile($viewFile, $viewData);
                if ($j++ < $n - 1)
                    echo $this->separator;
            }
        } else
            $this->renderEmptyText();
        if ($this->itemsTagName) {
            echo CHtml::closeTag($this->itemsTagName);
        }
    }

    public function registerClientScript()
    {
        $id = $this->getId();

        if ($this->ajaxUpdate === false)
            $ajaxUpdate = array();
        else
            $ajaxUpdate = array_unique(preg_split('/\s*,\s*/', $this->ajaxUpdate . ',' . $id, -1, PREG_SPLIT_NO_EMPTY));
        $options = array(
            'ajaxUpdate' => $ajaxUpdate,
            'ajaxVar' => $this->ajaxVar,
            'pagerClass' => $this->pagerCssClass,
            'loadingClass' => $this->loadingCssClass,
            'sorterClass' => $this->sorterCssClass,
            'enableHistory' => $this->enableHistory
        );
        if ($this->ajaxUrl !== null)
            $options['url'] = CHtml::normalizeUrl($this->ajaxUrl);
        if ($this->ajaxType !== null)
            $options['ajaxType'] = strtoupper($this->ajaxType);
        if ($this->updateSelector !== null)
            $options['updateSelector'] = $this->updateSelector;
        foreach (array('beforeAjaxUpdate', 'afterAjaxUpdate', 'ajaxUpdateError') as $event) {
            if ($this->$event !== null) {
                if ($this->$event instanceof CJavaScriptExpression)
                    $options[$event] = $this->$event;
                else
                    $options[$event] = new CJavaScriptExpression($this->$event);
            }
        }
    }

}
