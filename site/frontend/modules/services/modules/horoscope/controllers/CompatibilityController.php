<?php

class CompatibilityController extends HController
{
    public $layout = 'horoscope';
    public $title;
    public $social_title;

    public function filters()
    {
        return array(
            'ajaxOnly + Validate',
        );
    }

    /**
     * @sitemap dataSource=sitemapCompatibility
     */
    public function actionIndex($zodiac1 = null, $zodiac2 = null)
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
        } else {
            $str = Horoscope::model()->zodiac_list[$zodiac1] . ' и ' . Horoscope::model()->zodiac_list[$zodiac2];
            $this->meta_title = 'Гороскоп совместимости ' . $str;
            $this->meta_description = 'Гороскоп совместимости знаков Зодиака ' . $str . '.  Узнайте вашу совместимость.';
            $this->meta_keywords = 'Совместимость ' . $str . ', мужчина и женщина ' . $str;

            $model = HoroscopeCompatibility::model()->findByAttributes(array('zodiac1' => $zodiac1, 'zodiac2' => $zodiac2));
            if ($model === null) {
                $model = HoroscopeCompatibility::model()->findByAttributes(array('zodiac1' => $zodiac2, 'zodiac2' => $zodiac1));
                if ($model === null)
                    throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
                Yii::app()->clientScript->registerLinkTag('canonical', null, $this->createAbsoluteUrl('/services/horoscope/compatibility/index', array(
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

    public function sitemapCompatibility()
    {
        Yii::import('application.modules.services.modules.horoscope.models.Horoscope');

        $data = array();

        foreach (Horoscope::model()->zodiac_list_eng as $k1 => $z1) {
            foreach (Horoscope::model()->zodiac_list_eng as $k2 => $z2) {
                if ($k2 >= $k1)
                    $data[] = array(
                        'params' => array(
                            'zodiac1' => $z1,
                            'zodiac2' => $z2,
                        ),
                    );

            }
        }

        return $data;
    }
}