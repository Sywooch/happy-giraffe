<?php

class DefaultController extends HController
{
    public $layout = 'horoscope';
    public $title;
    public $social_title;

    /**
     * @sitemap
     */
    public function actionIndex()
    {
        $models = Horoscope::model()->findAllByAttributes(array('date' => date("Y-m-d")));
        $this->title = 'Гороскоп на сегодня по знакам Зодиака';

        $this->render('index', array('models' => $models, 'type' => 'today'));
    }

    /**
     * @sitemap dataSource=sitemapView
     */
    public function actionToday($zodiac, $date = null)
    {
        if (empty($date))
            $date = date("Y-m-d");

        $zodiac = Horoscope::model()->getZodiacId(trim($zodiac));
        $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'date' => $date));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->title = 'Гороскоп на сегодня ' . $model->zodiacText();
        $this->social_title = 'Гороскоп на сегодня ' . Yii::app()->dateFormatter->format('dd MMMM yyyy', strtotime($model->date)) . ' ' . $model->zodiacText();
        $this->breadcrumbs = array('Сервисы' => array('/'), 'Гороскоп' => array('index'), $this->title);
        $this->meta_title = 'Гороскоп на сегодня ' . $model->zodiacText() . ' для женщин и мужчин - Веселый Жираф';
        $this->meta_description = 'Бесплатный гороскоп ' . $model->zodiacText() . ' на сегодня для женщин и мужчин. Обновляется ежедневно!';
        $this->meta_keywords = 'Гороскоп на сегодня ' . $model->zodiacText() . ', ежедневный гороскоп ' . $model->zodiacText();

        $this->render('view', compact('model'));
    }


    /**
     * @sitemap dataSource=sitemapView
     */
    public function actionYesterday($zodiac)
    {
        $date = date("Y-m-d", strtotime('-1 day'));

        $zodiac = Horoscope::model()->getZodiacId(trim($zodiac));
        $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'date' => $date));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->title = 'Гороскоп на вчера ' . $model->zodiacText();
        $this->social_title = 'Гороскоп на ' . Yii::app()->dateFormatter->format('dd MMMM yyyy', strtotime($model->date)) . ' ' . $model->zodiacText();
        $this->breadcrumbs = array('Сервисы' => array('/'), 'Гороскоп' => array('index'), $this->title);
        $this->meta_title = 'Гороскоп на вчера ' . $model->zodiacText() . ' для мужчин и женщин - Веселый Жираф';
        $this->meta_description = 'Бесплатный гороскоп ' . $model->zodiacText() . ' на вчера для женщин и мужчин. Познай судьбу!';
        $this->meta_keywords = 'Гороскоп на вчера ' . $model->zodiacText();

        $this->render('view', compact('model'));
    }


    /**
     * @sitemap dataSource=sitemapView
     */
    public function actionTomorrow($zodiac = '')
    {
        $date = date("Y-m-d", strtotime('+1 day'));

        if (empty($zodiac)) {
            $this->title = 'Гороскоп на завтра по знакам Зодиака';

            $models = Horoscope::model()->findByAttributes(array('date' => $date));
            $this->render('index', array('models' => $models, 'type' => 'tomorrow'));
        } else {
            $zodiac = Horoscope::model()->getZodiacId(trim($zodiac));
            $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'date' => $date));
            if ($model === null)
                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

            $this->title = 'Гороскоп на завтра ' . $model->zodiacText();
            $this->social_title = 'Гороскоп на ' . Yii::app()->dateFormatter->format('dd MMMM yyyy', strtotime($model->date)) . ' ' . $model->zodiacText();
            $this->breadcrumbs = array('Сервисы' => array('/'), 'Гороскоп' => array('index'), $this->title);
            $this->meta_title = 'Гороскоп на завтра ' . $model->zodiacText() . ' для мужчин и женщин - Веселый Жираф';
            $this->meta_description = 'Бесплатный гороскоп ' . $model->zodiacText() . ' на завтра для женщин и мужчин. Обновляется ежедневно!';
            $this->meta_keywords = 'Гороскоп на завтра ' . $model->zodiacText() . ', ежедневный гороскоп ' . $model->zodiacText();

            $this->render('view', compact('model'));
        }
    }

    /**
     * @sitemap dataSource=sitemapView
     */
    public function actionMonth($zodiac = '')
    {
        if (empty($zodiac)) {
            $this->title = 'Гороскоп на месяц по знакам Зодиака';

            $models = Horoscope::model()->findByAttributes(array('year' => date('Y'), 'month' => date('n')));
            $this->render('index', array('models' => $models, 'type' => 'month'));
        } else {
            $zodiac = Horoscope::model()->getZodiacId($zodiac);
            $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'year' => date('Y'), 'month' => date('n')));
            if ($model === null)
                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

            $this->title = 'Гороскоп ' . $model->zodiacText() . ' на месяц';
            $this->social_title = 'Гороскоп ' . $model->zodiacText() . ' на ' . HDate::ruMonth(date('n'));
            $this->breadcrumbs = array('Сервисы' => array('/'), 'Гороскоп' => array('index'), $this->title);
            $this->meta_title = 'Гороскоп на каждый месяц ' . $model->zodiacText() . ' - Веселый Жираф';
            $this->meta_description = 'Бесплатный гороскоп на месяц ' . $model->zodiacText() . ' для женщин и мужчин. Обновляется ежемесячно!';
            $this->meta_keywords = 'Гороскоп на месяц ' . $model->zodiacText() . ', ежемесячный гороскоп ' . $model->zodiacText();

            $this->render('view', compact('model'));
        }
    }

    /**
     * @sitemap dataSource=sitemapView
     */
    public function actionYear($zodiac = '')
    {
        if (empty($zodiac)) {
            $this->title = 'Гороскоп на год по знакам Зодиака';

            $models = Horoscope::model()->findByAttributes(array('year' => date('Y'), 'month' => null, 'week' => null));
            $this->render('index', array('models' => $models, 'type' => 'year'));
        } else {
            $zodiac = Horoscope::model()->getZodiacId($zodiac);
            $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'year' => date('Y'), 'month' => null, 'week' => null));
            if ($model === null)
                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

            $this->title = 'Гороскоп ' . $model->zodiacText() . ' на ' . date('Y') . ' год';
            $this->social_title = $this->title;
            $this->breadcrumbs = array('Сервисы' => array('/'), 'Гороскоп' => array('index'), $this->title);
            $this->meta_title = 'Гороскоп ' . $model->zodiacText() . ' на ' . date('Y') . ' год для женщин и мужчин – Веселый Жираф';
            $this->meta_description = 'Бесплатный гороскоп ' . $model->zodiacText() . ' на ' . date('Y') . ' на завтра для женщин и мужчин. Познай свою судьбу!';
            $this->meta_keywords = 'Гороскоп на ' . date('Y') . ' год ' . $model->zodiacText() . ', гороскоп ' . $model->zodiacText() . ' на год';

            $this->render('view', compact('model'));
        }
    }

    public function sitemapView()
    {
        Yii::import('application.modules.services.modules.horoscope.models.Horoscope');

        $data = array();

        foreach (Horoscope::model()->zodiac_list_eng as $z) {
            $data[] = array(
                'params' => array(
                    'zodiac' => $z,
                ),
            );
        }

        return $data;
    }
}