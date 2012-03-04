<?php

/**
 * property CActiveRecord $model
 * property array $options
 * property array $providers
 */
class SocialLikeWidget extends CWidget
{

    /**
     * @var CActiveRecord
     */
    public $model;

    public $title;

    public $options;

    public $providers = array(
        'yh' => array(),
        'fb' => array(),
        'gp' => array(),
        'ok' => array(),
        'vk' => array(
            'id' => 2791084,
        ),
        'tw' => array(
            'via' => 'HappyGiraffe'
        ),
        'mr' => array(),
    );

    public function init()
    {
        parent::init();
        if(isset($this->options['image']) && !strstr($this->options['image'], 'http'))
            $this->options['image'] = Yii::app()->createAbsoluteUrl('/') . $this->options['image'];
        if(isset($this->options['description']))
            $this->options['description'] = Str::truncate(trim(strip_tags(html_entity_decode($this->options['description'], ENT_QUOTES, 'UTF-8'))), 300, '...');
        if(!isset($this->options['url']))
            $this->options['url'] = Yii::app()->createAbsoluteUrl(Yii::app()->request->pathInfo);

        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/social.js');
        Yii::app()->clientScript->registerScript('social_update_url', '
            Social.ajax_url = "' . Yii::app()->createUrl('/ajax/socialApi') . '";
            Social.update_url = "' . Yii::app()->createUrl('/ajax/rate') . '";
            Social.model_name = "' . get_class($this->model) . '";
            Social.model_id = "' . $this->model->primaryKey . '";
            Social.api_url = "' . $this->options['url'] . '"'
        );

        $this->render('index');
    }

    public function arrayToUrl($array)
    {
        $url = '';
        foreach($array as $key => $option)
            $url .= ($url == '' ? '?' : '&amp;') . $key . '=' . urlencode($option);
        return $url;
    }
}
