<?php
/**
 * Author: alexk984
 * Date: 13.03.12
 */

Yii::import('site.seo.models.*');
Yii::import('site.seo.models.mongo.*');
Yii::import('site.common.models.mongo.*');
Yii::import('site.seo.components.*');
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

    public function actionWordstat($thread_id = 0)
    {
        $parser = new WordstatFilter($thread_id);
        $parser->start();
    }

    public function actionProxy()
    {
        ProxyRefresher::execute();
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

        $result = array();
        $models = array(0);
        while (!empty($models)) {
            $models = PageView::model()->findAll($criteria);

            foreach ($models as $model)
                if (strpos($model->_id, '/cook/recipe/') !== false
                    || strpos($model->_id, '/cook/multivarka/') !== false
                )
                    $result [] = array('path' => $model->_id, 'views' => $model->views);

            $criteria->setOffset($criteria->getOffset() + 100);
        }

        //sort array
        usort($result, array($this, 'cmp'));
        $result = array_slice($result, 0, 100);
        foreach ($result as $model)
            echo 'http://www.happy-giraffe.ru' . $model['path'] . "\n";
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

    public function actionTest()
    {
        $data = array();
        $criteria = new CDbCriteria;
        $criteria->condition = 'type=' . LiSite::TYPE_LI . ' AND rubric_id IS NOT NULL AND visits>1000';
        $criteria->order = 'visits desc';
        $sites = LiSite::model()->findAll($criteria);
        $i = 1;
        foreach($sites as $site){
            $rows = array(
                $i,
                array('http://'.$site->url, $site->url),
                $site->rubric->title,
                ($site->visits*2 - rand(1,3))
            );
            $i++;
            $data[] = $rows;
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

