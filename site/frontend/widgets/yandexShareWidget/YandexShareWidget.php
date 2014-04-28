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
    private $_id;

    public function run()
    {
        $this->registerScript();
        $this->registerMeta();
        $json = CJSON::encode(array(
            'element' => $this->getElementId(),
            'theme' => 'counter',
            'elementStyle' => array(
                'quickServices' => array(
                    'vkontakte',
                    'odnoklassniki',
                    'facebook',
                    'twitter',
                    'moimir',
                    'gplus',
                ),
            ),
            'description' => $this->model->getPreviewText(),
            'image' => $this->getImageUrl(),
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

    public function registerScript()
    {
        /** @var ClientScript $cs */
        $cs = Yii::app()->clientScript;
        $cs->registerScriptFile('//yandex.st/share/share.js', null, array(
            'charset' => 'utf-8',
        ));
    }

    public function registerMeta()
    {
        /** @var ClientScript $cs */
        $cs = Yii::app()->clientScript;
        $cs->registerMetaTag($this->getImageUrl(), null, null, array('property' => 'og:image'));
    }

    protected function getDefaultImage()
    {
        return Yii::app()->request->hostInfo . '/new/images/base/logo.png';
    }

    protected function getImageUrl()
    {
        $photo = $this->model->getPreviewPhoto();
        return ($photo === null) ? $this->getDefaultImage() : $photo->getOriginalUrl();
    }
}