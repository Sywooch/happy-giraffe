<?php

class GeoOldController extends BController
{
    public function actionIndex()
    {
        echo geoip_record_by_name($_SERVER['REMOTE_ADDR']);
    }

    public function Kladr(){
        $file = Yii::app()->basePath . "\\www\\upload\\dbf_base\\ALTNAMES.DBF";
        $block = 50;
        $this->createtable($file);
        $data = $this->load_data($file, $block);
        $sql = 'CREATE TABLE IF NOT EXISTS `kladr_altnames` (
  `OLDCODE` varchar(19) DEFAULT NULL,
  `NEWCODE` varchar(19) DEFAULT NULL,
  `LEVEL` varchar(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;';
        Yii::app()->db->createCommand($sql)->execute();

        Yii::app()->db->createCommand('Truncate table `kladr_altnames`')->execute();
        foreach ($data as $row) {
            Yii::app()->db->createCommand('INSERT INTO `kladr_altnames` (`OLDCODE`, `NEWCODE`, `LEVEL`) VALUES '
                . $row)->execute();
        }

        $file = Yii::app()->basePath . "\\www\\upload\\dbf_base\\DOMA.DBF";
        $block = 50;
        $this->createtable($file);
        $data = $this->load_data($file, $block);
        $sql = 'CREATE TABLE IF NOT EXISTS `kladr_doma` (
  `NAME` varchar(40) DEFAULT NULL,
  `KORP` varchar(10) DEFAULT NULL,
  `SOCR` varchar(10) DEFAULT NULL,
  `CODE` varchar(19) DEFAULT NULL,
  `INDEX` varchar(6) DEFAULT NULL,
  `GNINMB` varchar(4) DEFAULT NULL,
  `UNO` varchar(4) DEFAULT NULL,
  `OCATD` varchar(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;';
        Yii::app()->db->createCommand($sql)->execute();
        Yii::app()->db->createCommand('Truncate table `kladr_doma`')->execute();
        foreach ($data as $row) {
            Yii::app()->db->createCommand('INSERT INTO `kladr_doma` (`NAME`, `KORP`, `SOCR`, `CODE`, `INDEX`, `GNINMB`, `UNO`, `OCATD`) VALUES'
                . $row)->execute();
        }
    }
    function createtable($file)
    {
        if ($openfile = @dbase_open($file, 0)) {
            $dbfhead = dbase_get_header_info($openfile);
            $count = count($dbfhead);
            for ($i = 0; $i < $count; $i++) {
                $mysql[$i] = $dbfhead[$i]["name"];
                $length = $dbfhead[$i]['length'];
                $precision = $dbfhead[$i]["precision"];
                # переводим тип поля из формата DBF в MySQL;
                # тут записаны не все типы полей существующие в DBF;
                switch ($dbfhead[$i]["type"]) {
                    case "number":
                        $mysql[$i] .= ($precision == 0) ? " INT" : " FLOAT";
                        break;
                    case "character":
                        $mysql[$i] .= " VARCHAR";
                        break;
                    case "date":
                        $mysql[$i] .= " DATE";
                        break;
                }
                $mysql[$i] .= "(" . $length;
                $mysql[$i] .= ($precision == 0) ? "" : "," . $precision;
                $mysql[$i] .= ")";
                $mysql[$i] .= ($i == $count - 1) ? "" : ",";
                # объединяем полученный массив в строку запроса MySQL;
                $querystr = "(";
                $querystr .= implode(" ", $mysql);
                $querystr .= ")";
            }
            return $querystr;
        }
        else {
            echo 'cannot open';
            return false;
        }
    }
    function load_data($file, $block)
    {
        if ($openfile = @dbase_open($file, 0)) {
            $countrec = dbase_numrecords($openfile);
            #$countfields = dbase_numfields($openfile);
            #echo "Записей в файле: ".$countrec . "<br>";
            #echo "Полей в строке " . $countfields . "<br>";
            $count = $countrec;
            $countdiv = (int)($count / $block);
            $countmod = (int)($count % $block);
            #echo $countdiv . " блоков по {$block} строк<br>";
            #echo "Последний блок {$countmod} строк<br>";
            for ($a = 1, $i = 0; $a <= $count; $i++) {
                # пока счетчик блоков не превышает количество целых блоков, размер блока остается равным заданному;
                # иначе значение счетчика приравнивается к количеству оставшихся записей (неполный блок);
                $block = ($i < $countdiv) ? $block : $countmod;
                for ($b = 0; $b < $block; $b++, $a++) {
                    $row = dbase_get_record_with_names($openfile, $a);
                    # удаляем поле с признаком deleted иначе будет не красиво - несоответствие;
                    # количества колонок в таблице MySQL и числа загружаемых значений;
                    unset($row['deleted']);
                    foreach ($row as $key => $value) {
                        $value = iconv("CP866", "UTF-8", $value);
                        $value = trim($value);
                        $row[$key] = '"'.htmlspecialchars($value, ENT_QUOTES, "UTF-8").'"';
                    }
                    # объединяем массив в строку;
                    $str[$b] = "(";
                    $str[$b] .= implode(", ", $row);
                    $str[$b] .= ")";
                    $str[$b] .= ($b == $block - 1) ? "" : ",";
                }
                # формируем массив строк для возврата из функции;
                # одна строка для одного запроса в MySQL;
                # длинна каждой строки определяется размером блока переданного функции;
                $data[] = implode(" ", $str);
                unset($str);
            }
            dbase_close($openfile);
            return $data;
        }
        else {
            echo 'cannot open';
            return false;
        }
    }
}
