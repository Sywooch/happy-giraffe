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
    /**
     * Коллекция фото
     * @var PhotoCollection
     */
    public $collection;

    /**
     * Ширина плитки
     * @var int
     */
    public $width = 580;

    /**
     * Максимальная высота ряда в плитке
     * @var int
     */
    public $maxHeight = 230;

    /**
     * Минимальное количество фотографий в ряду
     * @var int
     */
    public $minPhotos = 2;

    /**
     * Максимальное количество рядов
     * @var mixed
     */
    public $maxRows = false;

    /**
     * Отобразить виджет или же вернуть строку
     * @var bool
     */
    public $return = false;

    /**
     * Для регистрации скриптов
     * @var bool
     */
    public $registerScripts = false;

    /**
     * Ссылка, по которой перейдет пользователь при клике на любую фотографию
     * @var null
     */
    public $href = null;

    /**
     * Размер границ между фотографиями
     * @var int
     */
    public $borderSize = 5;

    /**
     * Дополнительные опции
     * @var null
     */
    public $windowOptions = null;

    /**
     * Максимальное количество фотографий для отображения
     * @var int
     */
    public $maxPhotos = 50;

    public function run()
    {
        $this->registerScripts();
        if ($this->registerScripts)
            return true;

        $grid = array();
        $buffer = array();
        $rowsCount = 0;
        $photosCount = 0;
        foreach ($this->collection->getAllPhotos($this->maxPhotos) as $photo) {
            $photosCount++;
            $photo = get_class($photo) == 'AlbumPhoto' ? $photo : $photo->photo;
            if ($photo->width === null || $photo->height === null)
                continue;

            $buffer[] = $photo;
            $height = ceil($this->getHeight($buffer));

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
        return ($this->width - (count($photos) - 1) * $this->borderSize) / array_reduce($photos, function($v, $w) {
            $v += $w->width / $w->height;
            return $v;
        }, 0);
    }

    protected function registerScripts()
    {
        /* @var $cs ClientScript */
        $cs = Yii::app()->clientScript;
        if ($cs->useAMD)
        {
            $cs->registerAMD('PhotoCollectionViewWidgettttttt', 'gallery');
        }
        else
        {
            $cs->registerPackage('gallery');
        }

        $this->widget('application.widgets.newCommentWidget.NewCommentWidget', array('registerScripts' => true));
        $this->widget('application.modules.favourites.widgets.FavouriteWidget', array('registerScripts' => true));
    }
}
