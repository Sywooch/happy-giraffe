<?php
/**
 * User: Eugene
 * Date: 29.02.12
 */
class AlbumWidget extends CWidget
{
    /**
     * @var User
     */
    public $model;

    public function run()
    {
        $albums = $this->model->getRelated('albums', true, array('limit' => 2));
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/stylesheets/user.css');
        $this->render('index', array(
            'albums' => $albums
        ));
    }
}
