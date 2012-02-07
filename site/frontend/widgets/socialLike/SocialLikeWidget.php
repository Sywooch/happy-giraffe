<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Eugene
 * Date: 06.02.12
 * Time: 12:15
 * To change this template use File | Settings | File Templates.
 */
class SocialLikeWidget extends CWidget
{
    public $model;

    public $options;

    public $providers = array(
        'vk' => array(
            'id' => 2791084,
        ),
        'fb' => array(),
        'tw' => array(
            'via' => 'HappyGiraffe'
        ),
        'ok' => array(),
        'gp' => array(

        ),
    );

    public function init()
    {
        parent::init();
        if(isset($this->options['image']) && !strstr($this->options['image'], 'http'))
            $this->options['image'] = Yii::app()->createAbsoluteUrl('/') . $this->options['image'];
        if(isset($this->options['description']))
            $this->options['description'] = Str::truncate(trim(strip_tags(html_entity_decode($this->options['description'], ENT_QUOTES, 'UTF-8'))), 300, '...');
        $this->render('index');
    }
}
