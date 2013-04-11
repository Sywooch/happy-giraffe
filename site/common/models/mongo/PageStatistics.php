<?php
/**
 * Author: alexk984
 * Date: 10.04.12
 */
class PageStatistics extends EMongoDocument
{
    public $url;
    public $visits;
    public $denial;
    public $page_views;
    public $depth;
    public $visit_time;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'page_statistics';
    }

    public static function add($data)
    {
        $model = new PageStatistics;
        foreach ($model->attributeNames() as $attr)
            if (isset($data[$attr]))
                $model->$attr = $data[$attr];
        $model->save();
    }

    public function export()
    {
        $criteria = new EMongoCriteria();
        $criteria->setSort(array('visits', EMongoCriteria::SORT_DESC));
        $pages = $this->model()->findAll($criteria);

        $i = 1;
        $data = array();
        foreach ($pages as $page) {
            //get article
            $page->url = str_replace('http://happy-giraffe.ru/', 'http://www.happy-giraffe.ru/', $page->url);
            list($entity, $entity_id) = Page::ParseUrl($page->url);
            $article = CActiveRecord::model($entity)->resetScope()->findByPk($entity_id);

            $rows = array();
            $rows[0] = $i;
            $rows[1] = array($page->url, $article->title);
            $rows[4] = '';
            if ($entity == 'CommunityContent') {
                $rows[2] = $article->rubric->community->title;
                if (isset($article->gallery))
                    $rows[4] = 'да';
            } else {
                $rows[2] = 'личный блог';
            }
            $rows[3] = $page->visits;
            $rows[5] = round($page->depth, 2);


            $data [] = $rows;
            if ($i >= 2000)
                break;
            $i++;
        }

        $this->excel($data);
    }

    public function excel($data)
    {
        $file_name = '/home/beryllium/file.xlsx';

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