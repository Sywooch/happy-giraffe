<?php
/**
 * Author: alexk984
 * Date: 13.03.12
 */
class SeoCommand extends CConsoleCommand
{
    public function actionIndex($thread = 1)
    {
        $this->Popularity($thread);
    }

    public function Popularity($thread)
    {
        Yii::import('site.seo.models.*');
        Yii::import('site.seo.components.*');
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');

//        $file = fopen('F:\Xedant\YANDEX_POPULARITY.txt', 'r');
        $file = fopen('/var/temporary/YANDEX_POPULARITY.txt', 'r');

        $start = ParseHelper::getLine($thread);
        $i = 0;
        if ($file) {
            while (($buffer = fgets($file)) !== false) {
                $i++;
                if ($i < $start)
                    continue;
                $line = trim($buffer);
                $parts = explode('|', $line);
                $last = '';
                foreach ($parts as $part)
                    $last = $part;
                $keyword = trim($parts[0]);
                $keyword = str_replace('$', '', $keyword);

                $stat = $last;

                $key = Keywords::model()->findByAttributes(array('name' => $keyword));
                if ($key !== null && !empty($last)) {
                    try {
                        $y_pop = new YandexPopularity();
                        $y_pop->keyword_id = $key->id;
                        $y_pop->value = $stat;
                        $y_pop->save();
                    } catch (Exception $e) {

                    }
                }

                if ($i % 1000 == 0) {
                    ParseHelper::setLine($thread, $i);
                }

                if ($i > 10000000 + $thread * 4000000)
                    break;
            }
            if (!feof($file)) {
                echo "Error: unexpected fgets() fail\n";
                Yii::app()->end();
            }
            fclose($file);
        }
    }

    public function actionParseQueriesYandex()
    {
        Yii::import('site.seo.models.*');
        Yii::import('site.seo.models.mongo.*');
        Yii::import('site.seo.components.*');
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Config::setAttribute('stop_threads', 0);

        $parser = new PositionParserThread(PositionParserThread::SE_YANDEX);
        $parser->start();
    }

    public function actionParseQueriesGoogle()
    {
        Yii::import('site.seo.models.*');
        Yii::import('site.seo.models.mongo.*');
        Yii::import('site.seo.components.*');
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Config::setAttribute('stop_threads', 0);

        $parser = new PositionParserThread(PositionParserThread::SE_GOOGLE);
        $parser->start();
    }
}

