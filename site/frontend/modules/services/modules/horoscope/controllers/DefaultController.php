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
        $models = Horoscope::model()->sortByZodiac()->findAllByAttributes(array('date' => date("Y-m-d")));
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

        $this->title = 'Гороскоп '.$model->zodiacText2().' на сегодня ';
        $this->social_title = 'Гороскоп на сегодня ' . Yii::app()->dateFormatter->format('dd MMMM yyyy', strtotime($model->date)) . ' ' . $model->zodiacText();
        $this->meta_title = 'Гороскоп на сегодня ' . $model->zodiacText() . ' для женщин и мужчин - Веселый Жираф';
        $this->meta_description = 'Бесплатный гороскоп ' . $model->zodiacText() . ' на сегодня для женщин и мужчин. Обновляется ежедневно!';
        $this->meta_keywords = 'Гороскоп на сегодня ' . $model->zodiacText() . ', ежедневный гороскоп ' . $model->zodiacText();

        $this->render('view', compact('model'));
    }

    /**
     * @sitemap dataSource=sitemapDateView
     */
    public function actionDate($zodiac, $date)
    {
        $zodiac = Horoscope::model()->getZodiacId(trim($zodiac));
        $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'date' => $date));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $text = $model->zodiacText2() . ' на ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($model->date));
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

        $this->title = 'Гороскоп '.$model->zodiacText2().' на вчера ';
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
            $this->title = 'Гороскоп на завтра';
            $this->social_title = 'Гороскоп на завтра по знакам Зодиака';
            $this->meta_title = 'Гороскоп на завтра по знакам Зодиака';
            $this->meta_description = 'Гороскопы для всех знаков Зодиака на завтра бесплатно';
            $this->meta_keywords = 'гороскоп на завтра, ежедневный гороскоп';

            $models = Horoscope::model()->sortByZodiac()->findAllByAttributes(array('date' => $date));
            $this->render('tomorrow', array('models' => $models, 'type' => 'tomorrow'));
        } else {
            $zodiac = Horoscope::model()->getZodiacId(trim($zodiac));
            $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'date' => $date));
            if ($model === null)
                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

            $this->title = 'Гороскоп '.$model->zodiacText2().' на завтра ';
            $this->social_title = 'Гороскоп на ' . Yii::app()->dateFormatter->format('dd MMMM yyyy', strtotime($model->date)) . ' ' . $model->zodiacText();
            $this->meta_title = 'Гороскоп на завтра ' . $model->zodiacText() . ' для мужчин и женщин - Веселый Жираф';
            $this->meta_description = 'Бесплатный гороскоп ' . $model->zodiacText() . ' на завтра для женщин и мужчин. Обновляется ежедневно!';
            $this->meta_keywords = 'Гороскоп на завтра ' . $model->zodiacText() . ', ежедневный гороскоп ' . $model->zodiacText();

            $this->render('tomorrow_one', compact('model'));
        }
    }

    /**
     * @sitemap dataSource=sitemapMonthView
     */
    public function actionMonth($zodiac = '', $month = '')
    {
        if (empty($zodiac)) {
            $this->title = 'Гороскоп на месяц';
            $this->social_title = $this->title;
            $this->meta_title = 'Гороскоп на каждый месяц';
            $this->meta_description = 'Ежемесячный гороскоп для всех знаков зодиака';
            $this->meta_keywords = 'гороскоп на месяц, ежемесячный гороскоп';

            $models = Horoscope::model()->sortByZodiac()->findAllByAttributes(array('year' => date('Y'), 'month' => date('n')));
            $this->render('month', array('models' => $models, 'type' => 'month'));
        } else {
            if (empty($month)) {
                $zodiac = Horoscope::model()->getZodiacId($zodiac);
                $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'year' => date('Y'), 'month' => date('n')));
                if ($model === null)
                    throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

                $this->title = 'Гороскоп ' . $model->zodiacText2() . ' на месяц';
                $this->social_title = 'Гороскоп ' . $model->zodiacText2() . ' на месяц';
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

                $this->title = 'Гороскоп '.$model->zodiacText2().' на ' . HDate::ruMonth($month) . ' ' . $year . ' года';
                $this->social_title = $this->title;
                $this->meta_title = $model->zodiacText(). '. Гороскоп ' . $model->zodiacText2() . ' на ' . HDate::ruMonth($month) . ' ' . $year . ' года';
                $this->meta_description = 'Гороскоп для ' . $model->zodiacText2().' на '.HDate::ruMonth($month) . ' ' . $year . ' года';
                $this->meta_keywords = 'Гороскоп ' . $model->zodiacText() . ', ' . HDate::ruMonth($month) . ' ' . $year;
                $model->calculateMonthDays();

                $this->render('month_one', compact('model'));
            }
        }
    }

    /**
     * @sitemap dataSource=sitemapYearView
     */
    public function actionYear($year = '', $zodiac = '')
    {
        if (empty($year))
            $year = 2012;

        if (empty($zodiac)) {
            $this->title = 'Гороскоп на ' . $year . ' год';
            $this->social_title = $this->title;
            $this->meta_title = 'Гороскоп на ' . $year . ' год. Гороскоп на 2013 год для всех знаков Зодиака';
            $this->meta_description = 'Гороскоп на ' . $year . ' для всех знаков Зодиака: здоровье, карьера, финансы и личная жизнь';
            $this->meta_keywords = 'Гороскоп на ' . $year . ' год, гороскоп ' . $year ;

            $models = Horoscope::model()->sortByZodiac()->findAllByAttributes(array('year' => $year, 'month' => null));
            $this->render('year', array('models' => $models, 'year' => $year));
        } else {
            $zodiac = Horoscope::model()->getZodiacId($zodiac);

            $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'year' => $year, 'month' => null));
            if ($model === null)
                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

            $this->title = 'Гороскоп ' . $model->zodiacText2() . ' на ' . $year . ' год';
            $this->social_title = $this->title;
            $this->meta_title = 'Гороскоп ' . $model->zodiacText() . ' на ' . $year . ' год для женщин и мужчин – Веселый Жираф';
            $this->meta_description = 'Бесплатный гороскоп ' . $model->zodiacText() . ' на ' . $year . ' год для женщин и мужчин. Познай свою судьбу!';
            $this->meta_keywords = 'Гороскоп на ' . $year . ' год ' . $model->zodiacText();

            $this->render('year_one', compact('model'));
        }
    }

    public function actionViewed()
    {
        UserAttributes::set(Yii::app()->user->id, 'horoscope', date("Y-m-d"));
    }

    public function actionLikes($zodiac, $date)
    {
        $this->layout = 'empty';
        $model = Horoscope::model()->findByAttributes(array('date' => $date, 'zodiac' => $zodiac));
        if ($model !== null)
            $this->render('likes_small', array('model' => $model));
    }

    public function sitemapView()
    {
        Yii::import('application.modules.services.modules.horoscope.models.Horoscope');

        $data = array();
        foreach (Horoscope::model()->zodiac_list_eng as $z)
            $data[] = array('params' => array('zodiac' => $z));

        return $data;
    }

    public function sitemapDateView()
    {
        $data = array();
        $dates = Yii::app()->db->createCommand()
            ->selectDistinct('date')
            ->from(Horoscope::model()->tableName())
            ->queryColumn();
        foreach ($dates as $date)
            if ($date !== '0000-00-00' && !empty($date)) {
                foreach (Horoscope::model()->zodiac_list_eng as $z) {
                    $data[] = array(
                        'params' => array(
                            'zodiac' => $z,
                            'date' => $date
                        ),
                    );
                }
            }

        return $data;
    }

    public function sitemapMonthView()
    {
        $data = array('params' => array());

        foreach (Horoscope::model()->zodiac_list_eng as $z)
            $data[] = array('params' => array('zodiac' => $z));

        $rows = Yii::app()->db->createCommand()
            ->selectDistinct(array('month', 'year'))
            ->from(Horoscope::model()->tableName())
            ->queryAll();
        foreach ($rows as $row)
            if (!empty($row['month']) && !empty($row['year'])) {
                foreach (Horoscope::model()->zodiac_list_eng as $z) {
                    $data[] = array(
                        'params' => array(
                            'zodiac' => $z,
                            'month' => $row['year'] . '-' . sprintf('%02d', $row['month'])
                        ),
                    );
                }
            }

        return $data;
    }

    public function sitemapYearView()
    {
        $data = array('params' => array());

        foreach (Horoscope::model()->zodiac_list_eng as $z)
            $data[] = array('params' => array('zodiac' => $z));

        $years = Yii::app()->db->createCommand()
            ->selectDistinct('year')
            ->from(Horoscope::model()->tableName())
            ->where('month IS NULL OR month =""')
            ->queryColumn();
        foreach ($years as $year)
            if (!empty($year))
                foreach (Horoscope::model()->zodiac_list_eng as $z) {
                    $data[] = array(
                        'params' => array(
                            'zodiac' => $z,
                            'year' => $year
                        ),
                    );
                }

        return $data;
    }
}