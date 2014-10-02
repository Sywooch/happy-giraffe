<?php

class DefaultController extends LiteController
{

    public $social_title;
    public $zodiac = false;
    public $date = false;
    public $period = false;
    public $alias = false;

    public function getUrl($params)
    {
        $defaultParams = array(
            'zodiac' => $this->zodiac,
            'date' => $this->date,
            'period' => $this->period,
            'alias' => $this->alias,
        );
        // Если перебивается дата, то сбрасываем алиас
        if (isset($params['date']))
        {
            $params['alias'] = false;
        }
        // Если перебивается алиас, то скидываем дату и период
        if (isset($params['alias']) && $params['alias'])
        {
            $params['date'] = false;
            $params['period'] = isset($params['period']) ? $params['period'] : 'day';
        }
        $params = CMap::mergeArray($defaultParams, $params);
        return Yii::app()->createUrl($this->route, $params);
    }

    public function beforeAction($action)
    {
        $this->zodiac = Yii::app()->request->getQuery('zodiac', false);
        $this->period = Yii::app()->request->getQuery('period', false);
        $this->date = Yii::app()->request->getQuery('date', false);
        $this->alias = Yii::app()->request->getQuery('alias', false);

        if ($this->alias === 'yesterday')
            throw new CHttpException(404);

        $package = Yii::app()->user->isGuest ? 'lite_horoscope' : 'lite_horoscope_user';
        Yii::app()->clientScript->registerPackage($package);
        Yii::app()->clientScript->useAMD = true;

        return parent::beforeAction($action);
    }

    public function actionList($zodiac, $period, $date, $alias)
    {
        $this->render('list');
    }

    public function actionView($zodiac, $period, $date, $alias)
    {
        $zodiac = Horoscope::model()->getZodiacId($this->zodiac);
        $model = null;
        switch ($this->period)
        {
            case 'day':
                $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'date' => date("Y-m-d", $date)));
                break;
            case 'month':
                $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'year' => date('Y', $date), 'month' => date('n', $date)));
                break;
            case 'year':
                $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'year' => date('Y', $date), 'month' => null));
                break;
        }
        if (!$model)
            throw new CHttpException(404);

        $this->render('view', array('model' => $model));
    }

}