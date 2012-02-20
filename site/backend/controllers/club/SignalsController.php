<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alexk984
 * Date: 20.02.12
 * Time: 16:13
 * To change this template use File | Settings | File Templates.
 */
class SignalsController extends BController
{
    public $section = 'club';
    public $layout = '//layouts/club';

    public function actionIndex()
    {
        $model = new ModerationSignals('search');
        $this->render('index', array(
            'model'=>$model
        ));
    }
}
