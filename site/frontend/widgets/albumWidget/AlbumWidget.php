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
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/stylesheets/user.css');
        $this->render('index', array(
            'albums' => $this->model->getRelated('albums', true, array('limit' => 2))
        ));
    }
}
