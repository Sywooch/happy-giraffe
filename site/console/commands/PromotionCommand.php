<?php
/**
 * Author: alexk984
 * Date: 04.10.12
 */

Yii::import('site.seo.models.*');
Yii::import('site.seo.models.mongo.*');
Yii::import('site.seo.components.*');
Yii::import('site.seo.modules.competitors.models.*');
Yii::import('site.seo.modules.writing.models.*');
Yii::import('site.seo.modules.promotion.models.*');
Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');

class PromotionCommand extends CConsoleCommand
{
    /** Парсим статистику по ключевым словам с метрики **/
    public function actionParseVisits()
    {
        $metrica = new YandexMetrica();
        $metrica->parseQueries();
    }

    public function actionTest()
    {
        Yii::import('site.common.models.mongo.*');
        PageStatistics::model()->parseSe();
    }

    /** Готовим парсинг позиций слов по которым заходили за последнюю неделю **/
    public function actionPrepare()
    {
        ParsingPosition::model()->deleteAll();
        ParsingPosition::collectKeywords();
    }

    /** Готовим парсинг позиций **/
    public function actionCollectPagesKeywords()
    {
        ParsingPosition::model()->deleteAll();
        ParsingPosition::collectPagesKeywords();
    }

    /** Парсинг позиций в Яндексе **/
    public function actionYandex($debug = 0)
    {
        $parser = new PositionParserThread(PositionParserThread::SE_YANDEX, $debug);
        $parser->start();
    }

    /** Парсинг позиций в Google **/
    public function actionGoogle($debug = 0)
    {
        $parser = new PositionParserThread(PositionParserThread::SE_GOOGLE, $debug);
        $parser->start();
    }

    public function actionPageViews()
    {
        Yii::import('site.frontend.helpers.*');
        $pages = PagePromotion::model()->findAll();
        foreach ($pages as $page) {
            $url = str_replace('http://www.happy-giraffe.ru', '', $page->url);
            $page->views = GApi::model()->uniquePageViews($url, '2012-01-01', '2013-04-12', false);
            echo $url . ' - ' . $page->views . "\n";
            $page->save();
        }
    }

    public function actionViews()
    {
        Yii::import('site.frontend.helpers.*');
        $criteria = new EMongoCriteria();
        $criteria->addCond('views', '==', null);
        $pages = PagePromotion::model()->findAll($criteria);
        foreach ($pages as $page) {
            $url = str_replace('http://www.happy-giraffe.ru', '', $page->url);
            $page->views = GApi::model()->uniquePageViews($url, '2011-01-01', '2013-04-12', false);
            echo $url . ' - ' . $page->views . "\n";
            $page->update(array('views'));
        }
    }

    public function actionAddToParsing()
    {
        $pages = PagePromotion::model()->findAll();
        foreach ($pages as $page) {
            $page2 = Page::model()->findByAttributes(array('url' => $page->url));
            if ($page2 === null) {
                $page2 = new Page;
                $page2->url = $page->url;
                $page2->save();
            }
            $phrase = PagesSearchPhrase::model()->findByAttributes(array(
                'page_id' => $page2->id,
                'keyword_id' => $page->keyword_id,
            ));
            if ($phrase === null) {
                $phrase = new PagesSearchPhrase;
                $phrase->page_id = $page2->id;
                $phrase->keyword_id = $page->keyword_id;
                $phrase->save();
            }
            $model = new ParsingPosition;
            $model->keyword_id = $page->keyword_id;
            $model->save();

        }
    }

    public function actionExport()
    {
        $urls = 'http://www.happy-giraffe.ru/horoscope/tomorrow/
http://www.happy-giraffe.ru/names/Milana/
http://www.happy-giraffe.ru/placentaThickness/
http://www.happy-giraffe.ru/community/26/forum/post/35010/
http://www.happy-giraffe.ru/community/2/forum/post/9208/
http://www.happy-giraffe.ru/community/24/forum/post/38802/
http://www.happy-giraffe.ru/community/3/forum/video/1094/
http://www.happy-giraffe.ru/community/33/forum/post/24403/
http://www.happy-giraffe.ru/community/10/forum/post/706/
http://www.happy-giraffe.ru/community/5/forum/post/27177/
http://www.happy-giraffe.ru/community/30/forum/post/5135/
http://www.happy-giraffe.ru/community/33/forum/post/29459/
http://www.happy-giraffe.ru/user/10378/blog/post17679/
http://www.happy-giraffe.ru/community/33/forum/post/25703/
http://www.happy-giraffe.ru/community/29/forum/post/35201/
http://www.happy-giraffe.ru/community/3/forum/post/46407/
http://www.happy-giraffe.ru/community/8/forum/post/23699/
http://www.happy-giraffe.ru/community/25/forum/post/21845/
http://www.happy-giraffe.ru/community/1/forum/post/27017/
http://www.happy-giraffe.ru/community/30/forum/post/35002/
http://www.happy-giraffe.ru/horoscope/taurus/
http://www.happy-giraffe.ru/community/6/forum/post/29505/
http://www.happy-giraffe.ru/community/25/forum/post/21913/
http://www.happy-giraffe.ru/menstrualCycle/
http://www.happy-giraffe.ru/horoscope/virgo/
http://www.happy-giraffe.ru/community/16/forum/post/1414/
http://www.happy-giraffe.ru/horoscope/tomorrow/cancer/
http://www.happy-giraffe.ru/community/24/forum/post/35491/
http://www.happy-giraffe.ru/community/2/forum/post/24047/
http://www.happy-giraffe.ru/community/24/forum/post/35333/
http://www.happy-giraffe.ru/community/30/forum/post/5467/
http://www.happy-giraffe.ru/horoscope/tomorrow/leo/
http://www.happy-giraffe.ru/pregnancyWeight/
http://www.happy-giraffe.ru/community/5/forum/post/935/
http://www.happy-giraffe.ru/community/29/forum/post/22259/
http://www.happy-giraffe.ru/community/24/forum/post/43177/
http://www.happy-giraffe.ru/community/33/forum/post/32020/
http://www.happy-giraffe.ru/community/29/forum/post/21603/
http://www.happy-giraffe.ru/user/15545/blog/post40023/
http://www.happy-giraffe.ru/community/24/forum/post/3412/
http://www.happy-giraffe.ru/community/33/forum/post/32964/
http://www.happy-giraffe.ru/community/33/forum/post/24723/
http://www.happy-giraffe.ru/horoscope/tomorrow/gemini/
http://www.happy-giraffe.ru/community/33/forum/post/31373/
http://www.happy-giraffe.ru/community/20/forum/post/4695/
http://www.happy-giraffe.ru/horoscope/tomorrow/virgo/
http://www.happy-giraffe.ru/community/10/forum/post/707/
http://www.happy-giraffe.ru/community/2/forum/post/29886/
http://www.happy-giraffe.ru/horoscope/tomorrow/taurus/
http://www.happy-giraffe.ru/horoscope/tomorrow/capricorn/
http://www.happy-giraffe.ru/community/24/forum/post/3445/
http://www.happy-giraffe.ru/horoscope/tomorrow/aquarius/
http://www.happy-giraffe.ru/community/2/forum/post/27703/
http://www.happy-giraffe.ru/community/10/forum/post/252/
http://www.happy-giraffe.ru/horoscope/tomorrow/scorpio/
http://www.happy-giraffe.ru/community/2/forum/post/914/
http://www.happy-giraffe.ru/community/25/forum/post/36921/
http://www.happy-giraffe.ru/community/25/forum/post/38115/
http://www.happy-giraffe.ru/community/30/forum/post/28503/
http://www.happy-giraffe.ru/community/1/forum/post/920/
http://www.happy-giraffe.ru/community/33/forum/post/30503/
http://www.happy-giraffe.ru/community/2/forum/post/33276/
http://www.happy-giraffe.ru/horoscope/tomorrow/sagittarius/
http://www.happy-giraffe.ru/community/2/forum/post/251/
http://www.happy-giraffe.ru/community/2/forum/post/15349/
http://www.happy-giraffe.ru/community/8/forum/post/28743/
http://www.happy-giraffe.ru/user/15588/blog/post30393/
http://www.happy-giraffe.ru/names/saint/
http://www.happy-giraffe.ru/community/2/forum/post/970/
http://www.happy-giraffe.ru/community/33/forum/post/30831/
http://www.happy-giraffe.ru/community/33/forum/post/32539/
http://www.happy-giraffe.ru/community/2/forum/post/989/
http://www.happy-giraffe.ru/community/33/forum/post/32988/
http://www.happy-giraffe.ru/community/24/forum/post/40032/
http://www.happy-giraffe.ru/community/8/forum/post/937/
http://www.happy-giraffe.ru/user/16057/blog/post43658/
http://www.happy-giraffe.ru/community/33/forum/post/43301/
http://www.happy-giraffe.ru/community/24/forum/post/5384/
http://www.happy-giraffe.ru/community/24/forum/post/3393/
http://www.happy-giraffe.ru/community/8/forum/post/30683/
http://www.happy-giraffe.ru/community/24/forum/post/14725/
http://www.happy-giraffe.ru/community/8/forum/post/32041/
http://www.happy-giraffe.ru/community/33/forum/post/23729/
http://www.happy-giraffe.ru/community/33/forum/post/33319/
http://www.happy-giraffe.ru/community/11/forum/post/27109/
http://www.happy-giraffe.ru/user/15322/blog/post32252/';
        $data = array();
        $urls = explode("\n", $urls);
        foreach ($urls as $url) {
            $pages = PagePromotion::model()->findAllByAttributes(array('url' => $url));
            foreach ($pages as $page) {
                $keyword = Keyword::model()->findByPk($page->keyword_id);
                $fields = array(
                    $page->url,
                    $keyword->id,
                    $keyword->name,
                    $page->strict_wordstat,
                    $page->yandex_pos,
                    $page->google_pos,
                    $page->views,
                    $page->se_traffic,
                );
                $data [] = $fields;
            }
        }

        $this->excel($data);
    }

    public function excel($data)
    {
        $file_name = 'f:/file.xlsx';

        $phpExcelPath = Yii::getPathOfAlias('site.common.extensions.phpExcel');
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator("Alex")
            ->setLastModifiedBy("Alex")
            ->setTitle("Articles")
            ->setSubject("Articles")
            ->setDescription("Articles");

        // Add some data
        $letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O');

        $sheet = $objPHPExcel->setActiveSheetIndex(0);
        $j = 1;
        foreach ($data as $fields) {
            for ($i = 0; $i < count($fields); $i++) {
                if (is_array($fields[$i])) {
                    $sheet->setCellValue($letters[$i] . $j, $fields[$i][1]);
                    $sheet->getCell($letters[$i] . $j)->getHyperlink()->setUrl($fields[$i][0]);
                } else
                    $sheet->setCellValue($letters[$i] . $j, $fields[$i]);
            }
            $j++;
        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($file_name);

        spl_autoload_register(array('YiiBase', 'autoload'));

        return $file_name;
    }
}