<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 2/10/13
 * Time: 2:56 PM
 * To change this template use File | Settings | File Templates.
 */
class HoroscopeController extends MController
{
    public function init()
    {
        Yii::import('site.frontend.modules.services.modules.horoscope.models.*');
    }

    public function actionIndex()
    {
//        $models = Horoscope::model()->sortByZodiac()->findAllByAttributes(array('date' => date("Y-m-d")));
        $models = Horoscope::model()->sortByZodiac()->findAllByAttributes(array('date' => date("2013-02-06")));

        $this->render('index', compact('models'));
    }
}
