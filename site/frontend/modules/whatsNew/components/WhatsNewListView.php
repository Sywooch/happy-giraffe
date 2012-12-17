<?php

Yii::import('zii.widgets.CListView');

/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/17/12
 * Time: 6:55 PM
 * To change this template use File | Settings | File Templates.
 */
class WhatsNewListView extends CListView
{
    public function renderItems()
    {
        echo CHtml::openTag($this->itemsTagName,array('class'=>$this->itemsCssClass))."\n";
        if ($this->dataProvider->pagination->currentPage == 0)
            $this->controller->renderPartial('/_update_message');
        $data=$this->dataProvider->getData();
        if(($n=count($data))>0)
        {
            $owner=$this->getOwner();
            $viewFile=$owner->getViewFile($this->itemView);
            $j=0;
            foreach($data as $i=>$item)
            {
                $data=$this->viewData;
                $data['index']=$i;
                $data['data']=$item;
                $data['widget']=$this;
                $owner->renderFile($viewFile,$data);
                if($j++ < $n-1)
                    echo $this->separator;
            }
        }
        else
            $this->renderEmptyText();
        echo CHtml::closeTag($this->itemsTagName);
    }
}
