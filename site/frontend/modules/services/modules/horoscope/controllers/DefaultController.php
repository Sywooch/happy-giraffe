<?php

class DefaultController extends HController
{
    public $layout = 'horoscope';
    public $title;
    public $social_title;

    public function filters()
    {
        return array(
            'ajaxOnly + viewed',
        );
    }

    /**
     * @sitemap
     */
    public function actionIndex()
    {
        $models = Horoscope::model()->findAllByAttributes(array('date' => date("Y-m-d")));
        $this->title = 'Гороскоп на сегодня по знакам Зодиака';
        $this->meta_title = $this->title;

        $this->render('index', array('models' => $models, 'type' => 'today'));
    }

    /**
     * @sitemap dataSource=sitemapView
     */
    public function actionToday($zodiac)
    {
        $date = date("Y-m-d");
        $zodiac = Horoscope::model()->getZodiacId(trim($zodiac));
        $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'date' => $date));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->title = 'Гороскоп на сегодня ' . $model->zodiacText();
        $this->social_title = 'Гороскоп на сегодня ' . Yii::app()->dateFormatter->format('dd MMMM yyyy', strtotime($model->date)) . ' ' . $model->zodiacText();
        $this->meta_title = 'Гороскоп на сегодня ' . $model->zodiacText() . ' для женщин и мужчин - Веселый Жираф';
        $this->meta_description = 'Бесплатный гороскоп ' . $model->zodiacText() . ' на сегодня для женщин и мужчин. Обновляется ежедневно!';
        $this->meta_keywords = 'Гороскоп на сегодня ' . $model->zodiacText() . ', ежедневный гороскоп ' . $model->zodiacText();

        $this->render('view', compact('model'));
    }

    public function actionDate($zodiac, $date = null)
    {
        $zodiac = Horoscope::model()->getZodiacId(trim($zodiac));
        $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'date' => $date));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $text = $model->zodiacText() . ' на ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($model->date));
        $this->title = 'Гороскоп ' . $text;
        $this->meta_title = 'Гороскоп ' . $text . ' для женщин и мужчин - Веселый Жираф';
        $this->meta_description = 'Бесплатный гороскоп ' . $text . ' для женщин и мужчин. Обновляется ежедневно!';
        $this->meta_keywords = $this->title;

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
            $this->meta_title = $this->title;

            $models = Horoscope::model()->findAllByAttributes(array('date' => $date));
            $this->render('tomorrow', array('models' => $models, 'type' => 'tomorrow'));
        } else {
            $zodiac = Horoscope::model()->getZodiacId(trim($zodiac));
            $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'date' => $date));
            if ($model === null)
                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

            $this->title = 'Гороскоп на завтра ' . $model->zodiacText();
            $this->social_title = 'Гороскоп на ' . Yii::app()->dateFormatter->format('dd MMMM yyyy', strtotime($model->date)) . ' ' . $model->zodiacText();
            $this->meta_title = 'Гороскоп на завтра ' . $model->zodiacText() . ' для мужчин и женщин - Веселый Жираф';
            $this->meta_description = 'Бесплатный гороскоп ' . $model->zodiacText() . ' на завтра для женщин и мужчин. Обновляется ежедневно!';
            $this->meta_keywords = 'Гороскоп на завтра ' . $model->zodiacText() . ', ежедневный гороскоп ' . $model->zodiacText();

            $this->render('tomorrow_one', compact('model'));
        }
    }

    /**
     * @sitemap dataSource=sitemapView
     */
    public function actionMonth($zodiac = '', $month = '')
    {
        if (empty($zodiac)) {
            $this->title = 'Гороскоп на месяц по знакам Зодиака';
            $this->meta_title = $this->title;

            $models = Horoscope::model()->findAllByAttributes(array('year' => date('Y'), 'month' => date('n')));
            $this->render('month', array('models' => $models, 'type' => 'month'));
        } else {
            if (empty($month)) {
                $zodiac = Horoscope::model()->getZodiacId($zodiac);
                $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'year' => date('Y'), 'month' => date('n')));
                if ($model === null)
                    throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

                $this->title = 'Гороскоп ' . $model->zodiacText() . ' на месяц';
                $this->social_title = 'Гороскоп ' . $model->zodiacText() . ' на ' . HDate::ruMonth(date('n'));
                $this->meta_title = 'Гороскоп на каждый месяц ' . $model->zodiacText() . ' - Веселый Жираф';
                $this->meta_description = 'Бесплатный гороскоп на месяц ' . $model->zodiacText() . ' для женщин и мужчин. Обновляется ежемесячно!';
                $this->meta_keywords = 'Гороскоп на месяц ' . $model->zodiacText() . ', ежемесячный гороскоп ' . $model->zodiacText();
                $model->calculateMonthDays();

                $this->render('month_one', compact('model'));
            } else {
                preg_match('/(\d\d\d\d)-(\d\d)/', $month, $matches);
                if (!isset($matches[1]) || !isset($matches[2]))
                    throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
                $year = $matches[1];
                $month = $matches[2];

                $zodiac = Horoscope::model()->getZodiacId($zodiac);
                $model = Horoscope::model()->findByAttributes(array(
                    'zodiac' => $zodiac,
                    'year' => $year,
                    'month' => $month
                ));
                if ($model === null)
                    throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

                $this->title = 'Гороскоп ' . $model->zodiacText() . ' на ' . HDate::ruMonth($month) . ' ' . $year . ' года';
                $this->social_title = 'Гороскоп ' . $model->zodiacText() . ' на ' . HDate::ruMonth(date('n'));
                $this->meta_title = $this->title;
                $this->meta_description = 'Бесплатный гороскоп на ' . HDate::ruMonth($month) . ' ' . $year . ' года для женщин и мужчин. Обновляется ежемесячно!';
                $model->calculateMonthDays();

                $this->render('month_one', compact('model'));
            }
        }
    }

    /**
     * @sitemap dataSource=sitemapView
     */
    public function actionYear($zodiac = '', $year = '')
    {
        if (empty($zodiac)) {
            $this->title = 'Гороскоп на год по знакам Зодиака';
            $this->meta_title = $this->title;

            $models = Horoscope::model()->findAllByAttributes(array('year' => date('Y'), 'month' => null));
            $this->render('year', array('models' => $models, 'type' => 'year'));
        } else {
            $zodiac = Horoscope::model()->getZodiacId($zodiac);

            if (empty($year)) {
                $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'year' => date('Y'), 'month' => null));
                if ($model === null)
                    throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

                $this->title = 'Гороскоп ' . $model->zodiacText() . ' на год';
                $this->social_title = $this->title;
                $this->meta_title = 'Гороскоп ' . $model->zodiacText() . ' на год для женщин и мужчин – Веселый Жираф';
                $this->meta_description = 'Бесплатный гороскоп ' . $model->zodiacText() . ' на год для женщин и мужчин. Познай свою судьбу!';
                $this->meta_keywords = 'гороскоп ' . $model->zodiacText() . ' на год';

                $this->render('year_one', compact('model'));

            } else {
                $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'year' => $year, 'month' => null));
                if ($model === null)
                    throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

                $this->title = 'Гороскоп ' . $model->zodiacText() . ' на ' . $year . ' год';
                $this->social_title = $this->title;
                $this->meta_title = 'Гороскоп ' . $model->zodiacText() . ' на ' . $year . ' год для женщин и мужчин – Веселый Жираф';
                $this->meta_description = 'Бесплатный гороскоп ' . $model->zodiacText() . ' на ' . $year . ' год для женщин и мужчин. Познай свою судьбу!';
                $this->meta_keywords = 'Гороскоп на ' . $year . ' год ' . $model->zodiacText();

                $this->render('year_one', compact('model'));
            }
        }
    }

    public function actionViewed()
    {
        UserAttributes::set(Yii::app()->user->id, 'horoscope', date("Y-m-d"));
    }

    public function actionLikes(){
        $this->layout = 'empty';
        $this->render('likes');
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