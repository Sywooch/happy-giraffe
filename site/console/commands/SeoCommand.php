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
    public function actionStopThreads()
    {
        Config::setAttribute('stop_threads', 1);
    }

    public function actionProxy()
    {
        ProxyRefresher::executeMongo();
    }

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

                    $first = true;
                    foreach ($samePages as $samePage) {
                        echo $samePage->outputLinksCount . ' : ' . $samePage->inputLinksCount
                            . ' : ' . $samePage->taskCount . ' : ' . $samePage->phrasesCount
                            . ' : ' . $samePage->keywordGroup->taskCount
                            . ' : ' . count($samePage->keywordGroup->keywords) . "\n";

//                        if ($samePage->outputLinksCount == 0
//                            && $samePage->inputLinksCount == 0
//                            && $samePage->taskCount == 0
//                            && $samePage->phrasesCount == 0
//                            && empty($samePage->keywordGroup->keywords)
//                            && $samePage->keywordGroup->taskCount == 0
//                        ) {
                        if (!$first)
                            $samePage->delete();
//                        }

                        $first = false;
                    }
                }
            }

            echo $criteria->offset . "\n";
            $criteria->offset += 900;
        }
    }

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

    public function actionPopular()
    {
        $criteria = new EMongoCriteria();
        $criteria->limit(100);
        $criteria->sort('views', EMongoCriteria::SORT_DESC);

        $models = PageView::model()->findAll($criteria);
        $res = array();
        foreach ($models as $model) {
            $se_visits = GApi::model()->organicSearches($model->_id, '2013-03-21', '2013-06-21', false);
            if ($se_visits > 100)
                echo 'http://www.happy-giraffe.ru' . $model->_id . ' - ' . $se_visits . "\n";

                $res[$model->_id] = (int)$se_visits;
        }

        arsort($res);
        foreach($res as $key=>$val)
            echo $key."\n";
    }

    function cmp($a, $b)
    {
        if ($a['views'] == $b['views'])
            return 0;
        return ($a['views'] > $b['views']) ? -1 : 1;
    }

    public function actionParseTraffic()
    {
        TrafficStatisctic::model()->parse();
    }

    public function actionParseSeTraffic()
    {
        Yii::import('site.frontend.helpers.*');
        Yii::import('site.frontend.extensions.*');
        PageStatistics::model()->parseSe();
    }

    public function actionExport()
    {
        Yii::import('site.frontend.helpers.*');
        Yii::import('site.frontend.extensions.*');
        PageStatistics::model()->export();
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

    public function actionTest(){
        $str = '/community/26/forum/post/35010/
/community/12/forum/post/3327/
/community/33/forum/post/33749/
/community/2/forum/post/5071/
/community/1/forum/post/2384/
/community/33/forum/post/43301/
/community/33/forum/post/33252/
/community/10/forum/post/709/
/community/10/forum/post/4929/
/community/33/forum/post/5116/
/community/33/forum/post/5187/
/community/8/forum/post/23111/
/community/20/forum/post/30106/
/community/11/forum/post/27109/
/community/26/forum/post/3336/
/community/33/forum/post/30828/
/community/25/forum/post/28273/
/community/10/forum/post/704/
/community/11/forum/post/21329/
/community/8/forum/post/32041/
/community/31/forum/post/50501/
/user/83/blog/post29894/
/community/33/forum/post/4165/
/community/22/forum/post/28281/
/community/33/forum/post/32020/
/community/33/forum/post/21899/
/community/29/forum/post/34455/
/community/33/forum/post/32486/
/community/2/forum/post/49948/
/community/8/forum/post/3335/';

        $lines = file('F:/analitics.csv');
        $f = fopen('F:/res.txt', 'w');
        $urls = explode("\n", $str);

        foreach($urls as $url){
            $url = trim($url);
            fputs($f, $url."  ");
            foreach($lines as $line)
                if (strpos($line, $url)){
                    $keyword = explode(',', $line);
                    fputs($f, $keyword[0].' , ');
                }

            fputs($f, "\n");
        }
    }
}

