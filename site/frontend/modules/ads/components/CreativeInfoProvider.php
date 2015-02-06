<?php
namespace site\frontend\modules\ads\components;

/**
 * @property string $name
 * @property string $url
 * @property string $html
 * @property int width
 * @property int height
 *
 * @author Никита
 * @date 05/02/15
 */


class CreativeInfoProvider extends \CComponent
{
    protected $template;
    protected $model;

    public function __construct($template, \CActiveRecord $model)
    {
        if ($model->asa('AdvertisedBehavior') === null) {
            throw new \CException('Модель должна иметь поведение Advertised');
        }

        $this->template = $template;
        $this->model = $model;
    }

    public function getName()
    {
        return $this->model->getCreativeName();
    }

    public function getUrl()
    {
        return $this->model->getCreativeUrl();
    }

    public function getHtml()
    {
        return \Yii::app()->controller->renderPartial($this->getViewFile(), array(
            'model' => $this->model,
        ), true);
    }

    public function getWidth()
    {
        return \Yii::app()->getModule('ads')->templates[$this->template]['size']['width'];
    }

    public function getHeight()
    {
        return \Yii::app()->getModule('ads')->templates[$this->template]['size']['height'];
    }
}