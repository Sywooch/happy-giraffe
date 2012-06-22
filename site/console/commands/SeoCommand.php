<?php
/**
 * Author: alexk984
 * Date: 13.03.12
 */

Yii::import('site.seo.models.*');
Yii::import('site.seo.models.mongo.*');
Yii::import('site.seo.components.*');
Yii::import('site.seo.modules.competitors.models.*');
Yii::import('site.seo.modules.writing.models.*');
Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');

class SeoCommand extends CConsoleCommand
{
    public function actionIndex($thread = 1)
    {
        $this->ramblerPopular($thread);
    }

    public function Popularity($thread)
    {
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
                        $y_pop = new PastuhovYandexPopularity();
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

    public function ramblerPopular($thread)
    {
//        $file = fopen('F:\Xedant\RAMBLER_ALL.txt', 'r');
        $file = fopen('/var/temporary/RAMBLER_ALL.txt', 'r');

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
                        $pop = new RamblerPopularity();
                        $pop->keyword_id = $key->id;
                        $pop->value = $stat;
                        $pop->save();
                    } catch (Exception $e) {

                    }
                }

                if ($i % 1000 == 0) {
                    ParseHelper::setLine($thread, $i);
                }

                if ($i > 2000000 + $thread * 2000000)
                    break;
            }
            if (!feof($file)) {
                echo "Error: unexpected fgets() fail\n";
                Yii::app()->end();
            }
            fclose($file);
        }
    }

    public function actionParseSeVisits()
    {
        $metrica = new YandexMetrica();
        $metrica->parseQueries();
        $metrica->convertToPageSearchPhrases();
    }

    public function actionConvertPositions()
    {
        $metrica = new YandexMetrica();
        $metrica->convertToPageSearchPhrases();
    }

    public function actionParseMonthTraffic()
    {
        $metrica = new YandexMetrica(1);
        $metrica->parseQueries();
        $metrica->convertToPageSearchPhrases();

        $metrica = new YandexMetrica(2);
        $metrica->parseQueries();
        $metrica->convertToPageSearchPhrases();

        $metrica = new YandexMetrica(3);
        $metrica->parseQueries();
        $metrica->convertToPageSearchPhrases();
    }


    public function actionParseQueriesYandex()
    {
        Config::setAttribute('stop_threads', 0);

        $parser = new PositionParserThread(PositionParserThread::SE_YANDEX);
        $parser->start();
    }

    public function actionParseQueriesGoogle()
    {
        Config::setAttribute('stop_threads', 0);

        $parser = new PositionParserThread(PositionParserThread::SE_GOOGLE);
        $parser->start();
    }

    public function actionWordstat($mode = 0)
    {
        $parser = new WordstatParser();
        $parser->start($mode);
    }
}

