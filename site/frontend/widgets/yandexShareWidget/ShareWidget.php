<?php
/**
 * @author Никита
 * @date 20/07/15
 */

class ShareWidget extends CWidget
{
    public $model;

    public $title;
    public $description;
    public $imageUrl;
    public $url;

    public function init()
    {
        if (! $this->model instanceof IPreview) {
            throw new CException('Сущность должна реализовывать интерфейс IPreview');
        }

        if ($this->title === null) {
            $this->title = $this->getTitle();
        }

        if ($this->description === null) {
            $this->description = $this->getDescription();
        }

        if ($this->imageUrl === null) {
            $this->imageUrl = $this->getImageUrl();
        }

        if ($this->url === null) {
            $this->url = $this->getUrl();
        }
    }

    protected function registerMeta()
    {
        /** @var ClientScript $cs */
        $cs = Yii::app()->clientScript;
        $cs->registerMetaTag($this->title, null, null, array('property' => 'og:title'));
        $cs->registerMetaTag($this->url, null, null, array('property' => 'og:url'));
        $cs->registerMetaTag($this->imageUrl, null, null, array('property' => 'og:image'));
        $cs->registerMetaTag($this->description, null, null, array('property' => 'og:description'));
    }

    protected function getDefaultImage()
    {
        return Yii::app()->request->hostInfo . '/new/images/external/vg-200-x-200.png';
    }

    protected function getTitle()
    {
        return Yii::app()->controller->pageTitle;
    }

    protected function getUrl()
    {
        return Yii::app()->createAbsoluteUrl(Yii::app()->request->url);
    }

    protected function getImageUrl()
    {
        $photo = $this->model->getPreviewPhoto();

        if ($photo === null) {
            return $this->getDefaultImage();
        } elseif ($photo instanceof AlbumPhoto) {
            return $photo->getPreviewUrl(800, null, Image::WIDTH);
        } else {
            return $photo;
        }

    }

    protected function getDescription()
    {
        $description = $this->model->getPreviewText();
        return (strlen($description) > 0) ? Str::getDescription($description, 128) : $this->getTitle();
    }
}