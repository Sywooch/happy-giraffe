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
        'vk' => array(
            'id' => 2791084,
        ),
        'gp' => array(),
        'mr' => array(),
        'fb' => array(),
        'tw' => array(
            'via' => 'HappyGiraffe'
        ),
        'ok' => array(),
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
        RatingCache::checkCache($this->model, $this->providers, $this->options['url']);
        $this->render('index');
    }
}
