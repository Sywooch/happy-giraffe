<?php

class DefaultController extends HController
{
    public $layout = 'horoscope';
    public $title;

    public function actionIndex()
    {
        $models = Horoscope::model()->findAllByAttributes(array('date' => date("Y-m-d")));
        if (empty($models))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->breadcrumbs = array('Сервисы' => array('/'), 'Гороскоп');

        $this->pageTitle = 'Гороскоп на сегодня, ' . Yii::app()->dateFormatter->format('d MMMM', strtotime(date("Y-m-d")));
        $this->render('index', compact('models'));
    }

    public function actionView($zodiac, $date = null)
    {
        if ($date == null || empty($date))
            $date = date("Y-m-d");

        $zodiac = Horoscope::model()->getZodiacId($zodiac);
        $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'date' => $date));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->title = 'Гороскоп ' . $model->zodiacText() . ' на ' . Yii::app()->dateFormatter->format('d MMMM', strtotime($date));
        $this->breadcrumbs = array('Сервисы' => array('/'), 'Гороскоп' => array('index'), $this->title);
        $this->pageTitle = $this->title;

        $this->render('date', compact('model'));
    }

    public function actionWeek($zodiac)
    {
        $zodiac = Horoscope::model()->getZodiacId($zodiac);
        $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'year' => date('Y'), 'week' => date('W')));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->title = 'Гороскоп ' . $model->zodiacText() . ' на неделю';
        $this->breadcrumbs = array('Сервисы' => array('/'), 'Гороскоп' => array('index'), $this->title);
        $this->pageTitle = $this->title;

        $this->render('week', compact('model'));
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
}