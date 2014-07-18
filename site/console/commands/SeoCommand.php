<?php
/**
 * Author: alexk984
 * Date: 13.03.12
 */

Yii::import('site.seo.models.*');
Yii::import('site.seo.models.mongo.*');
Yii::import('site.common.models.mongo.*');
Yii::import('site.seo.components.*');
Yii::import('site.seo.components.wordstat.*');
Yii::import('site.seo.modules.competitors.models.*');
Yii::import('site.seo.modules.writing.models.*');
Yii::import('site.seo.modules.promotion.models.*');
Yii::import('site.seo.modules.traffic.models.*');
Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
Yii::import('site.frontend.helpers.*');

class SeoCommand extends CConsoleCommand
{
    /**
     * Обновление актуальных прокси для работы, запускается по крону раз в 5 минут
     */
    public function actionProxy()
    {
        ProxyRefresher::executeMongo();
    }

    /**
     * Удаление дубликатов страниц в таблице pages
     */
    public function actionDeletePageDuplicates()
    {
        Yii::import('site.common.behaviors.*');
        $criteria = new CDbCriteria;
        $criteria->limit = 1000;
        $criteria->offset = 0;

        $models = array(0);
        while (!empty($models)) {
            $models = Page::model()->findAll($criteria);

            foreach ($models as $model) {
                $criteria2 = new CDbCriteria;
                $criteria2->compare('url', $model->url);
                $criteria2->order = 'id asc';
                $samePages = Page::model()->findAll($criteria2);
                if (count($samePages) > 1) {
                    echo $model->url . ' - ' . count($samePages) . "\n";

                    foreach ($samePages as $samePage) {
                        $samePage->delete();
                    }
                }
            }

            echo $criteria->offset . "\n";
            $criteria->offset += 900;
        }
    }

    /**
     * Проверка правильности entity в таблицу pages
     */
    public function actionCheckEntities()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->offset = 0;

        $models = array(0);
        while (!empty($models)) {
            $models = Page::model()->findAll($criteria);

            foreach ($models as $model) {
                list($entity, $entity_id) = Page::ParseUrl($model->url);

                if (!empty($entity) && !empty($entity_id) && $entity != $model->entity) {
                    echo $entity . "\n";
                    $model->entity = $entity;
                    $model->entity_id = $entity_id;
                    $model->save();
                }
            }

            $criteria->offset += 100;
        }
    }

    /**
     * Парсинг ежедневного трафика на разделы/модули сайта (сео-модуль "Трафик")
     * http://seo.happy-giraffe.ru/traffic/default/index/
     */
    public function actionParseTraffic()
    {
        TrafficStatisctic::model()->parse();
    }

    public function actionParseMetrika($date)
    {
        $metrika = new YandexMetrica();
        $metrika->parseDate($date);
    }

    public function actionCompare($date1, $date2)
    {
        $metrika = new YandexMetrica();
        $metrika->compareDates2($date1, $date2);
    }

//    public function actionParseSeTraffic()
//    {
//        Yii::import('site.frontend.helpers.*');
//        Yii::import('site.frontend.extensions.*');
//        PageStatistics::model()->parseSe();
//    }
//
//    public function actionExport()
//    {
//        Yii::import('site.frontend.helpers.*');
//        Yii::import('site.frontend.extensions.*');
//        PageStatistics::model()->export();
//    }

    public function actionFixUsersUrls()
    {
        include_once Yii::getPathOfAlias('site.frontend.vendor.simplehtmldom_1_5') . DIRECTORY_SEPARATOR . 'simple_html_dom.php';

        $criteria = new CDbCriteria(array(
            'order' => 't.id DESC',
            'condition' => 'id = 1192041',
        ));

        $dp = new CActiveDataProvider('Comment', array(
            'criteria' => $criteria,
        ));
        $iterator = new CDataProviderIterator($dp, 1000);
        foreach ($iterator as $comment) {
            if ($dom = str_get_html($comment->text)) {
                $needUpdate = false;
                foreach ($dom->find('a') as $a) {
                    if (preg_match('#\/user\/(\d+)\/$#', $a->href, $matches)) {
                        $id = $matches[1];
                        $user = User::model()->findByPk($id);
                        if ($user === null || $user->deleted = 1) {
                            $needUpdate = true;
                            $a->outertext = '<span class="a-imitation">' . $a->innertext . '</span>';
                        }
                    }
                }
                if ($needUpdate) {
                    $comment->text = (string) $dom;
                    $comment->update(array('text'));
                    $comment->purified->clearCache();
                }
            }
        }
    }
}

