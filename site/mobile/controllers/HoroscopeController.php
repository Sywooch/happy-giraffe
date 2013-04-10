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
        $models = Horoscope::model()->sortByZodiac()->findAllByAttributes(array('date' => date("2013-02-06")));

        $this->pageTitle = 'Гороскоп на сегодня по знакам Зодиака';
        $this->render('index', compact('models'));
    }

    public function actionView($zodiac, $type)
    {
        $zodiac = Horoscope::model()->getZodiacId($zodiac);
        switch ($type) {
            case 'today':
                $attributes = array('zodiac' => $zodiac, 'date' => date("Y-m-d"));
                $titleSuffix = 'сегодня';
                break;
            case 'tomorrow':
                $attributes = array('zodiac' => $zodiac, 'date' => date("Y-m-d", strtotime('+1 day')));
                $titleSuffix = 'завтра';
                break;
            case 'month':
                $attributes = array('zodiac' => $zodiac, 'year' => date('Y'), 'month' => date('n'));
                $titleSuffix = 'месяц';
                break;
            case 'year':
                $attributes = array('zodiac' => $zodiac, 'year' => 2012, 'month' => null);
                $titleSuffix = 'год';
                break;
        }
        $model = Horoscope::model()->findByAttributes($attributes);
        $title = 'Гороскоп ' . $model->zodiacText2() . ' на ' . $titleSuffix;
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->pageTitle = $title;
        $this->render('view', compact('model', 'title', 'type'));
    }
}
