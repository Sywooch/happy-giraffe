<?php
/**
 * Author: alexk984
 * Date: 11.10.12
 */

Yii::import('site.seo.models.*');
Yii::import('site.seo.models.mongo.*');
Yii::import('site.seo.components.*');
Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');

class WordstatCommand extends CConsoleCommand
{
    const WORDSTAT_LIMIT = 200;

    public function actionAddCompetitors()
    {
        $keywords = Yii::app()->db_seo->createCommand('select distinct(keyword_id) from sites__keywords_visits ')->queryColumn();
        echo count($keywords);
        foreach ($keywords as $keyword_id) {
            $model = ParsingKeyword::model()->findByPk($keyword_id);
            if ($model === null) {
                $m = new ParsingKeyword;
                $m->keyword_id = $keyword_id;
                $m->priority = 100;
                $m->save();
            } else
                ParsingKeyword::model()->updateByPk($keyword_id, array('priority' => 100));
        }
    }

    public function actionAddKeywordsFromFile()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.common.models.mongo.*');

        $path = Yii::app()->params['keywords_path'];
        $handle = @fopen($path, "r");
        $i = 0;
        $start_line = UserAttributes::get(1, 'start_file_line', 3800000);
        while (($buffer = fgets($handle)) !== false) {
            $i++;
            if ($i < $start_line)
                continue;

            $keyword = trim(substr($buffer, 0, strpos($buffer, ',')));
            $keyword_model = Keyword::model()->findByAttributes(array('name' => $keyword));
            if ($keyword_model === null) {
                $keyword_model = new Keyword();
                $keyword_model->name = $keyword;
                try {
                    $keyword_model->save();
                    ParsingKeyword::addNewKeyword($keyword_model);
                } catch (Exception $e) {
                }
            }
            if ($i % 10000 == 0) {
                echo $i . "\n";
                UserAttributes::set(1, 'start_file_line', $i);
            }
        }
        fclose($handle);
    }

    public function actionModify($num = 1)
    {
        $parser = new WordstatQueryModify();
        $parser->addToParsing($num);
    }

    public function actionFixPriority($i = 0)
    {
        $ids = 1;
        while (!empty($ids)) {
            $ids = Yii::app()->db_keywords->createCommand()
                ->select('id')
                ->from('keywords')
                ->where('wordstat >= 1000')
                ->limit(1000)
                ->offset($i * 1000)
                ->queryColumn();

            Yii::app()->db_keywords->createCommand()->update('parsing_keywords', array('priority' => 201),
                'keyword_id IN (' . implode(',', $ids) . ')');

            $i++;
//            if ($i % 10 == 0)
//                echo $i . "\n";
        }
    }

    public function actionFix2()
    {
        $deleted = 0;
        for ($i = 0; $i < 120; $i++) {
            $ids = Yii::app()->db_seo->createCommand()
                ->selectDistinct('keyword_id')
                ->from('sites__keywords_visits')
                ->limit(10000)
                ->offset(10000 * $i - $deleted)
                ->queryColumn();

            foreach ($ids as $id) {
                $exist = Yii::app()->db_keywords->createCommand()->select('id')->from('keywords')->where('id=' . $id)->queryScalar();
                if (empty($exist)) {
                    Yii::app()->db_seo->createCommand()->delete('sites__keywords_visits', 'keyword_id=' . $id);
                    $deleted++;
                }
            }

            echo $deleted . "\n";
        }
    }

    public function actionProxyMongo()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 1000;
        $i = 0;
        $proxies = array(1);
        while (!empty($proxies)) {
            $criteria->offset = 1000 * $i;

            $proxies = Proxy::model()->findAll($criteria);
            foreach ($proxies as $proxy) {
                $mongo_proxy = new ProxyMongo;
                $mongo_proxy->value = $proxy->value;
                $mongo_proxy->rank = $proxy->rank;
                $mongo_proxy->save();
            }

            $i++;
        }
    }

    public function actionProxyMongoCheck()
    {
        $start_time = microtime(true);

        $model = ProxyMongo::model()->findAndModify(array(
            'update' => array('$set' => array('active' => 1)),
            'query' => array('active' => 0),
            'sort' => array('rating' => EMongoCriteria::SORT_DESC),
        ));

        echo 1000 * (microtime(true) - $start_time) . "\n";
        echo $model['value'];
    }
}