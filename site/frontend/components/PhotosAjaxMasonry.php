<?php
class PhotosAjaxMasonry extends CWidget
{
    public $dataProvider;
    public $linkId = 'more-btn';
    public $linkClass = 'more-btn';
    public $linkText = ' Показать еще фотографии ';


    public function init()
    {
        //$this->pager = new CLinkPager();
        $cs = Yii::app()->clientScript;
        $cs->registerScriptFile('/javascripts/photosAjaxMasonry.js');
    }

    public function run()
    {

        $pager = new CLinkPager();
        $cpagination = $this->dataProvider->getPagination();
        $pager = $cpagination;


        if ($cpagination->currentPage + 1 < $cpagination->pageCount) {
            $nextUrl = $pager->createPageUrl($cpagination->currentPage + 1);
            echo '<a href="' . $nextUrl . '" class="' . $this->linkClass . '" id="' . $this->linkId . '" data-loading="0">' . $this->linkText . '</a>';
        }
    }
}
