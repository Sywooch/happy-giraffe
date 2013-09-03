<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 7/9/13
 * Time: 1:45 PM
 * To change this template use File | Settings | File Templates.
 */

class PhotoCollectionViewWidget extends CWidget
{
    public $collection;
    public $width = 580;
    public $maxHeight = 230;
    public $minPhotos = 2;
    public $maxRows = false;
    public $return = false;
    public $registerScripts = false;
    public $href = null;

    public function run()
    {
        $this->registerScripts();
        if ($this->registerScripts)
            return true;

        $grid = array();
        $buffer = array();
        $rowsCount = 0;
        $photosCount = 0;
        foreach ($this->collection->getAllPhotos() as $photo) {
            $photosCount++;
            $photo = get_class($photo) == 'AlbumPhoto' ? $photo : $photo->photo;
            if ($photo->width === null || $photo->height === null)
                continue;

            $buffer[] = $photo;
            $height = floor($this->getHeight($buffer));

            if ($this->collection->count == $photosCount || (($this->collection->count - $photosCount) >= $this->minPhotos  && count($buffer) >= $this->minPhotos && $height <= $this->maxHeight)) {
                $grid[] = array(
                    'height' => $height,
                    'photos' => $buffer,
                );
                $buffer = array();
                $rowsCount++;
                if ($this->maxRows !== false && $this->maxRows == $rowsCount)
                    break;
            }
        }

        if ($this->return)
            return $this->render('PhotoCollectionViewWidget', compact('collection', 'grid'), true);
        else
            $this->render('PhotoCollectionViewWidget', compact('collection', 'grid'));
    }

    public function getHeight($photos)
    {
        return ($this->width - count($photos) * 4) / array_reduce($photos, function($v, $w) {
            $v += $w->width / $w->height;
            return $v;
        }, 0);
    }

    protected function registerScripts()
    {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript
            ->registerScriptFile('/javascripts/jquery.history.js')
            ->registerScriptFile('/javascripts/ko_gallery.js')
            ->registerScriptFile($baseUrl . '/PhotoCollectionViewWidget.js')
        ;

        $this->widget('application.widgets.newCommentWidget.NewCommentWidget', array('registerScripts' => true));
        $this->widget('application.modules.favourites.widgets.FavouriteWidget', array('registerScripts' => true));
    }
}
