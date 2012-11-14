<?php
/**
 * User: alexk984
 * Date: 13.11.12
 *
 */
class HoroscopeCommand extends CConsoleCommand
{
    public function beforeAction($action)
    {
        Yii::import('site.frontend.modules.services.modules.horoscope.models.*');

        return true;
    }

    /**
     * Выделяем разделы из гороскопа на год
     */
    public function actionIndex()
    {
        $models = Horoscope::model()->findAll('year IS NOT NULL AND month IS NULL');
        echo count($models)."\n";

        foreach($models as $model){
            preg_match('/<b>Здоровье.<\/b>([^\<]+)/', $model->text, $match);
            $model->health = trim($match[1]);

            preg_match('/<b>Карьера.<\/b>([^\<]+)/', $model->text, $match);
            $model->career = trim($match[1]);

            preg_match('/<b>Финансы.<\/b>([^\<]+)/', $model->text, $match);
            $model->finance = trim($match[1]);

            preg_match('/<b>Личная жизнь.<\/b>([^\<]+)/', $model->text, $match);
            $model->personal = trim($match[1]);

            $model->save();
        }

        $models = Horoscope::model()->findAll('year IS NOT NULL AND month IS NOT NULL');
        echo count($models)."\n";

        foreach($models as $model){
            preg_match('/<b>Благоприятные дни[А-я\s:\d]{0,20}<\/b>[\s:–-–—]+([\d\s,]+)/u', $model->text, $match);
            if (!isset($match[1])){
                echo '1_ '.$model->id."\n";
            }
            else
            $model->good_days = trim($match[1]);

            preg_match('/<b>Неблагоприятные дни[А-я\s:\d]{0,20}<\/b>[\s:–––—]+([\d\s,]+)/u', $model->text, $match);
            if (!isset($match[1])){
                echo '2_ '.$model->id."\n";
            }
            else
                $model->bad_days = trim($match[1]);

            $model->save();
        }
    }

    public function actionRemove(){
        $models = Horoscope::model()->findAll('year IS NOT NULL AND month IS NOT NULL');
        echo count($models)."\n";

        foreach($models as $model){
            $pos = strpos($model->text, '<b>Благоприятные');

            if (!empty($pos)){
                $model->text = trim(substr($model->text, 0, $pos - 1));
            }else
                echo $model->id."\n";

            $model->save();
        }
    }
}
