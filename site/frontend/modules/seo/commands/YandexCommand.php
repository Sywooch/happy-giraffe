<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 04/06/14
 * Time: 12:48
 */

namespace site\frontend\modules\seo\commands;


use site\frontend\modules\seo\models\SeoYandexOriginalText;
use site\frontend\modules\seo\components\YandexOriginalText;
\Yii::import('site.common.extensions.restcurl.*');

class YandexCommand extends \CConsoleCommand
{
    /**
     * @var YandexOriginalText
     */
    public $original;

    public function init()
    {
        $this->original = new YandexOriginalText();
    }

    public function actionIndex()
    {
        $models = SeoYandexOriginalText::model()->pending()->findAll();

        foreach ($models as $model) {
            if ($this->original->add($model)) {
                $model->save();
            } else {
                break;
            }
        }
    }

    public function actionSync($page = 0)
    {
        $this->original->sync($page);
    }

    public function actionWorker()
    {
        $originalTexts = new YandexOriginalText();

        \Yii::app()->gearman->worker()->addFunction('processOriginalText', function($job) use ($originalTexts) {
//            $data = unserialize($job->workload());
//
//            $model = new SeoYandexOriginalText();
//            $model->setAttributes($data);
//
//            print_r($model->attributes);
//            die;
//
//            $model->priority = 100;
//
//            $originalTexts->add($model);
//
//            $model->save();
        });
        while (\Yii::app()->gearman->worker()->work()) {
            echo "OK\n";
        }
    }
} 