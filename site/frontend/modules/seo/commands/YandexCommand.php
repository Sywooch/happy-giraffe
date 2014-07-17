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
            $data = unserialize($job->workload());

            $model = new SeoYandexOriginalText();
            $model->setAttributes($data);
            $model->priority = 100;

            if ($originalTexts->add($model)) {
                $model->save();
            }
        });
        while (\Yii::app()->gearman->worker()->work()) {
            echo "OK\n";
        }
    }

    public function actionAddHg()
    {
        $dp = new \CActiveDataProvider('CommunityContent', array(
            'criteria' => array(
                'condition' => 'by_happy_giraffe = 1',
            ),
        ));
        $iterator = new \CDataProviderIterator($dp, 1000);
        foreach ($iterator as $contentModel) {
            $model = new SeoYandexOriginalText();
            $model->setAttributes(SeoYandexOriginalText::getAttributesByModel($contentModel));
            $model->priority = 99;
            $model->external_id = null;
            $model->save();
        }
    }
} 