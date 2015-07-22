<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 26/04/14
 * Time: 11:19
 * To change this template use File | Settings | File Templates.
 */

Yii::import('application.widgets.yandexShareWidget.ShareWidget');

class YandexShareWidget extends ShareWidget
{
    public $widgetTitle = 'Поделитесь с друзьями!';
    public $lite = false;

    private $_id;

    public function run()
    {
        $this->registerMeta();
        $json = CJSON::encode(array(
            'element' => $this->getElementId(),
            'theme' => 'counter',
            'elementStyle' => array(
                //'type' => 'small',
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
        $this->registerScript($json);
        $this->render($this->getView(), compact('json'));
    }

    public function getElementId()
    {
        if ($this->_id === null) {
            $this->_id = 'ya_share_' . md5(get_class($this->model) . $this->model->primaryKey);
        }
        return $this->_id;
    }

    protected function getView()
    {
        return $this->lite === true ? 'lite' : 'view';
    }

    protected function registerScript($json)
    {
        /** @var ClientScript $cs */
        $cs = Yii::app()->clientScript;
        if ($cs->useAMD)
        {
            $cs->amd['shim']['ya.share'] = array('exports' => 'Ya');
            $cs->amd['paths']['ya.share'] = '//yandex.st/share/share';
            $cs->registerAMD('YandexShare#' . $this->id, array('Ya' => 'ya.share'), "new Ya.share(" . $json . ");");
        }
        else
        {
            $cs->registerScriptFile('//yandex.st/share/share.js', null, array(
                'charset' => 'utf-8',
            ));
            $cs->registerScript('YandexShare#' . $this->id, "new Ya.share(" . $json . ");", ClientScript::POS_LOAD);
        }
    }
}