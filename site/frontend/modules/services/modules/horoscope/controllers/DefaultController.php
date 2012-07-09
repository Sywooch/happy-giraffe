<?php

class DefaultController extends HController
{
    public $layout = 'horoscope';
    public $title;

    /**
     * @sitemap
     */
    public function actionIndex()
    {
        $models = Horoscope::model()->findAllByAttributes(array('date' => date("Y-m-d")));
        $this->breadcrumbs = array('Сервисы' => array('/'), 'Гороскоп');

        $this->pageTitle = 'Гороскоп на сегодня, ' . Yii::app()->dateFormatter->format('d MMMM', strtotime(date("Y-m-d")));
        $this->render('index', compact('models'));
    }

    public function actionView($zodiac, $date = null)
    {
        if (empty($date))
            $date = date("Y-m-d");

        $zodiac = Horoscope::model()->getZodiacId(trim($zodiac));
        $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'date' => $date));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->title = 'Гороскоп ' . $model->zodiacText() . ' на сегодня';
        $this->breadcrumbs = array('Сервисы' => array('/'), 'Гороскоп' => array('index'), $this->title);
        $this->pageTitle = $this->title;

        $this->render('date', compact('model'));
    }

    public function actionYesterday($zodiac){
        $date = date("Y-m-d", strtotime('-1 day'));

        $zodiac = Horoscope::model()->getZodiacId(trim($zodiac));
        $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'date' => $date));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->title = 'Гороскоп ' . $model->zodiacText() . ' на вчера';
        $this->breadcrumbs = array('Сервисы' => array('/'), 'Гороскоп' => array('index'), $this->title);
        $this->pageTitle = $this->title;

        $this->render('date', compact('model'));
    }

    public function actionTomorrow($zodiac){
        $date = date("Y-m-d", strtotime('+1 day'));

        $zodiac = Horoscope::model()->getZodiacId(trim($zodiac));
        $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'date' => $date));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->title = 'Гороскоп ' . $model->zodiacText() . ' на завтра';
        $this->breadcrumbs = array('Сервисы' => array('/'), 'Гороскоп' => array('index'), $this->title);
        $this->pageTitle = $this->title;

        $this->render('date', compact('model'));
    }

    public function actionMonth($zodiac)
    {
        $zodiac = Horoscope::model()->getZodiacId($zodiac);
        $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'year' => date('Y'), 'month' => date('n')));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->title = 'Гороскоп ' . $model->zodiacText() . ' на ' . HDate::ruMonth(date('n')) . ' ' . date('Y') . ' года';
        $this->breadcrumbs = array('Сервисы' => array('/'), 'Гороскоп' => array('index'), $this->title);
        $this->pageTitle = $this->title;

        $this->render('month', compact('model'));
    }

    public function actionYear($zodiac)
    {
        $zodiac = Horoscope::model()->getZodiacId($zodiac);
        $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'year' => date('Y'), 'month' => null, 'week' => null));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->title = 'Гороскоп ' . $model->zodiacText() . ' на ' . date('Y') . ' год';
        $this->breadcrumbs = array('Сервисы' => array('/'), 'Гороскоп' => array('index'), $this->title);
        $this->pageTitle = $this->title;

        $this->render('year', compact('model'));
    }

    public function actionCompatibility($zodiac1 = null, $zodiac2 = null){
        if ($zodiac1 == null && $zodiac2 == null){
            $model = new HoroscopeCompatibility();
            $this->render('compatibility_main', compact('model'));
        }elseif($zodiac1 == null && $zodiac2 != null){
            $this->render('compatibility_one',array('zodiac'=>$zodiac1));
        }elseif($zodiac1 == null && $zodiac2 != null){
            $this->render('compatibility_two',compact('zodiac1', 'zodiac2'));
        }
    }

    public function actionCalculate(){

    }
}