<?php
class PhotosAjaxMasonry extends CWidget
{
    public $dataProvider;
    public $controller;

    public $linkId = 'more-btn';
    public $linkClass = 'more-btn';
    public $linkText = ' Показать еще фотографии ';

    public $gallerySelector;
    public $galleryEntity;
    public $galleryEntity_id;
    public $galleySinglePhoto;

    public $masonryContainerSelector;
    public $masonryItemSelector;
    public $masonryColumnWidth;


    public function init()
    {
        $cs = Yii::app()->clientScript;
        $cs->registerScriptFile('/javascripts/photosAjaxMasonry.js');

        Yii::app()->clientScript->registerScript(
            'photosAjaxMasonry', ' photosAjaxMasonry.init("' . $this->masonryContainerSelector . '","' . $this->masonryItemSelector . '","' . $this->masonryColumnWidth . '")'
        );
    }

    public function run()
    {
        $pager = new CLinkPager();
        $cpagination = $this->dataProvider->getPagination();
        $pager->pages = $cpagination;

        if ($cpagination->currentPage + 1 < $cpagination->pageCount) {
            $nextUrl = $pager->getPages()->createPageUrl($this->controller, $cpagination->currentPage + 1);
            $params = array(
                'class' => $this->linkClass,
                'id' => $this->linkId,
                'data-loading' => '0',
                'onclick' => 'photosAjaxMasonry.load(this, event); return false;',
                'data-gallery-entity' => $this->galleryEntity,
                'data-gallery-entity-id' => $this->galleryEntity_id,
                'data-gallery-selector' => $this->gallerySelector,
                'data-gallery-single-photo' => $this->galleySinglePhoto,
                'data-masonry-selector' => $this->masonryContainerSelector
            );
            echo CHtml::link($this->linkText, $nextUrl, $params);
        }
    }
}
