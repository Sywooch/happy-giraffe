<?php

class CompatibilityController extends LiteController
{

    public function beforeAction($action)
    {
        $package = Yii::app()->user->isGuest ? 'lite_horoscope' : 'lite_horoscope_user';
        Yii::app()->clientScript->registerPackage($package);
        Yii::app()->clientScript->useAMD = true;

        return parent::beforeAction($action);
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

        if ($zodiac1 == null && $zodiac2 == null)
        {
            $model = new HoroscopeCompatibility();
            $this->render('compatibility_main', compact('model'));
        }
        else
        {
            $model = HoroscopeCompatibility::model()->findByAttributes(array('zodiac1' => $zodiac1, 'zodiac2' => $zodiac2));
            if ($model === null)
            {
                $model = HoroscopeCompatibility::model()->findByAttributes(array('zodiac1' => $zodiac2, 'zodiac2' => $zodiac1));
                if ($model === null)
                    throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
                $this->metaCanonical = $this->createAbsoluteUrl('/services/horoscope/compatibility/index', array(
                        'zodiac1' => Horoscope::model()->zodiac_list_eng[$zodiac2],
                        'zodiac2' => Horoscope::model()->zodiac_list_eng[$zodiac1],
                ));
                $i = $model->zodiac1;
                $model->zodiac1 = $model->zodiac2;
                $model->zodiac2 = $i;
            }

            $this->render('compatibility_one', compact('model'));
        }
    }

    public function sitemapCompatibility()
    {
        Yii::import('application.modules.services.modules.horoscope.models.Horoscope');

        $data = array();

        foreach (Horoscope::model()->zodiac_list_eng as $k1 => $z1)
        {
            foreach (Horoscope::model()->zodiac_list_eng as $k2 => $z2)
            {
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