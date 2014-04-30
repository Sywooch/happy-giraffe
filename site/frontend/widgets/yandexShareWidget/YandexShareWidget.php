<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 26/04/14
 * Time: 11:19
 * To change this template use File | Settings | File Templates.
 */

class YandexShareWidget extends CWidget
{
    /**
     * @var HActiveRecord|IPreview
     */
    public $model;

    public $title;
    public $description;
    public $imageUrl;
    public $url;

    private $_id;

    public function init()
    {
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

    public function run()
    {
        $this->registerMeta();
        $this->registerScript();
        $json = CJSON::encode(array(
            'element' => $this->getElementId(),
            'theme' => 'counter',
            'elementStyle' => array(
                'type' => 'small',
                'quickServices' => array(
                    'vkontakte',
                    'odnoklassniki',
                    'facebook',
                    'twitter',
                    'moimir',
                    'gplus',
                ),
            ),
            'link' => $this->url,
            'description' => $this->description,
            'image' => $this->imageUrl,
        ));
        $this->render('view', compact('json'));
    }

    public function getElementId()
    {
        if ($this->_id === null) {
            $this->_id = 'ya_share_' . md5(get_class($this->model) . $this->model->primaryKey);
        }
        return $this->_id;
    }

    protected function registerScript()
    {
        /** @var ClientScript $cs */
        $cs = Yii::app()->clientScript;
        $cs->registerScriptFile('//yandex.st/share/share.js', null, array(
            'charset' => 'utf-8',
        ));
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
        return Yii::app()->request->hostInfo . '/new/images/external/vg-200-x-200-2.png';
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
        return ($photo === null) ? $this->getDefaultImage() : $photo->getPreviewUrl(800, null, Image::WIDTH);
    }

    protected function getDescription()
    {
        $description = $this->model->getPreviewText();
        return (strlen($description) > 0) ? $description : $this->getTitle();
    }
}