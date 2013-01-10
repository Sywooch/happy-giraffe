<?php
/**
 * Author: alexk984
 * Date: 10.01.13
 */
class SeoExport
{
    public static function csv($list, $delimiter = ',')
    {
        $file_name = self::getFileName('.csv');
        $fp = fopen($file_name, 'w');

        foreach ($list as $fields) {
            fputcsv($fp, $fields, $delimiter);
        }

        fclose($fp);
    }

    public static function txt($list, $delimiter = ',')
    {
        $file_name = self::getFileName('.txt');
        $fp = fopen($file_name, 'w');

        foreach ($list as $fields) {
            fputcsv($fp, $fields, $delimiter);
        }

        fclose($fp);
    }

    public static function excel($list)
    {
        $file_name = self::getFileName('.xlsx');

        $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');
        spl_autoload_unregister(array('YiiBase','autoload'));
        include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator("Key-ok")
            ->setLastModifiedBy("Key-ok")
            ->setTitle("Keywords")
            ->setSubject("Keywords")
            ->setDescription("Keywords");

        // Add some data
        $letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O');

        $sheet = $objPHPExcel->setActiveSheetIndex(0);
        $j = 0;
        foreach ($list as $fields) {
            for($i=0;$i<count($fields);$i++){
                $sheet = $sheet->setCellValue($letters[$i].$j, $fields[$i]);
            }
            $j++;
        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($file_name);

        spl_autoload_register(array('YiiBase','autoload'));
    }

    public static function getFileName($ext)
    {
        $dir = Yii::getPathOfAlias('site.seo.files.keywords');

        $file_name = substr(md5(microtime()), 0, 15);
        while (file_exists($dir . DIRECTORY_SEPARATOR . $file_name . $ext))
            $file_name = substr(md5(microtime()), 0, 15);

        return $dir . DIRECTORY_SEPARATOR . $file_name . $ext;
    }
}
