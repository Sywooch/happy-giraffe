<?php

class DefaultController extends HController
{
    public $layout = 'horoscope';
    public $title;

    public function filters()
    {
        return array(
            'ajaxOnly + Validate',
        );
    }

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

    public function actionYesterday($zodiac)
    {
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

    public function actionTomorrow($zodiac)
    {
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

    public function actionCompatibility($zodiac1 = null, $zodiac2 = null)
    {
        if ($zodiac1 == null && $zodiac2 != null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        if ($zodiac1 !== null)
            $zodiac1 = Horoscope::model()->getZodiacId($zodiac1);
        if ($zodiac2 !== null)
            $zodiac2 = Horoscope::model()->getZodiacId($zodiac2);

        if ($zodiac1 == null && $zodiac2 == null) {
            $model = new HoroscopeCompatibility();
            $this->render('compatibility_main', compact('model'));
        } else
         {

            $model = HoroscopeCompatibility::model()->findByAttributes(array('zodiac1' => $zodiac1, 'zodiac2' => $zodiac2));
            if ($model === null) {
                $model = HoroscopeCompatibility::model()->findByAttributes(array('zodiac1' => $zodiac2, 'zodiac2' => $zodiac1));
                if ($model === null)
                    throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
                Yii::app()->clientScript->registerLinkTag('canonical', null, $this->createUrl('/services/horoscope/default/compatibility', array(
                    'zodiac1' => Horoscope::model()->zodiac_list_eng[$zodiac2],
                    'zodiac2' => Horoscope::model()->zodiac_list_eng[$zodiac1],
                )));
                $i = $model->zodiac1;
                $model->zodiac1 = $model->zodiac2;
                $model->zodiac2 = $i;
            }

            $this->render('compatibility_one', compact('model'));
        }
    }

    public function actionValidate()
    {
        if (isset($_POST['ajax'])) {
            $model = new HoroscopeCompatibility;
            $model->attributes = $_POST['HoroscopeCompatibility'];
            echo CActiveForm::validate($model);
        }
    }
}