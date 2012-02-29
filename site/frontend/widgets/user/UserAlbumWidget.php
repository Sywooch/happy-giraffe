<?php
/**
 * User: Eugene
 * Date: 29.02.12
 */
class UserAlbumWidget extends UserCoreWidget
{
    /**
     * @var User
     */
    public $model;

    public function run()
    {
        parent::init();
        $albums = $this->model->getRelated('albums', true, array('limit' => 2));
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/stylesheets/user.css');
        $this->render('UserAlbumWidget', array(
            'albums' => $albums
        ));
    }
}
