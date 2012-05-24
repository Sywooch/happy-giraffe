<?php

class DefaultController extends SController
{
    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('admin'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    public function actionIndex($site_id = 1, $year = 2011)
    {
        $model = new KeyStats;
        $model->site_id = $site_id;
        $model->year = $year;

        $this->render('index', array(
            'model' => $model,
            'site_id' => $site_id,
            'year' => $year
        ));
    }

    public function actionCalc()
    {
        $site_id = 1;
        $year = 2012;
        $criteria = new CDbCriteria;
        $criteria->compare('site_id', $site_id);
        $criteria->compare('year', $year);
        $stats = Stats::model()->findAll($criteria);
        foreach ($stats as $stat) {
            $key_stat = KeyStats::model()->find('site_id = ' . $site_id . ' AND keyword_id = ' . $stat->keyword_id . ' AND year = ' . $year);
            if ($key_stat === null) {
                $key_stat = new KeyStats;
                $key_stat->keyword_id = $stat->keyword_id;
                $key_stat->site_id = $site_id;
                $key_stat->year = $year;
            }
            $key_stat->setAttribute('m' . $stat->month, $stat->value);
            $key_stat->save();
        }
    }

    public function actionAddKeys()
    {
        $file = fopen('F:\Xedant\Keywords.txt', 'r');
        $i = 0;
        $sql = '';
        $continue = false;
        if ($file) {
            while (($buffer = fgets($file)) !== false) {
                $i++;
                $keyword = trim(ltrim($buffer, '#'));
                $keyword = str_replace("'", '', $keyword);
                $keyword = str_replace("\\", '', $keyword);

                if ($keyword == 'приказ министра обороны 310 1999г')
                    $continue = true;

                if ($continue) {
                    $sql .= 'INSERT INTO keywords (`id` ,`name`)VALUES (NULL ,  \'' . $keyword . '\');';

                    if ($i % 2000 == 0) {
                        $command = Yii::app()->db_seo->createCommand($sql);
                        $command->execute();
                        $sql = '';
                    }
                }
            }
            if (!feof($file)) {
                echo "Error: unexpected fgets() fail\n";
                Yii::app()->end();
            }
            fclose($file);
        }
    }

    public function actionPopularity()
    {
        $file = fopen('F:\Xedant\YANDEX_POPULARITY.txt', 'r');
        $i = 0;
        if ($file) {
            while (($buffer = fgets($file)) !== false) {
                $i++;
                if ($i < 6170)
                    continue;
                $line = trim(ltrim($buffer));
                $parts = explode('|', $line);
                $last = '';
                foreach ($parts as $part)
                    $last = $part;
                $keyword = trim($parts[0]);

                $keyword = str_replace('$', '', $keyword);
                $stat = $last;

                $key = Keywords::GetKeyword($keyword);
                if ($key !== null && !empty($last)) {
                    Yii::app()->db_seo->createCommand('CALL saveYP (:key_id, :stat)')->execute(array(
                        ':key_id' => $key->id,
                        ':stat' => $stat,
                    ));
                    /*if (!YandexPopularity::model()->exists('keyword_id=' . $key->id)) {
                        $popularity = new YandexPopularity();
                        $popularity->keyword_id = $key->id;
                        $popularity->value = $stat;
                        $popularity->save();
                    }*/
                }

                $i++;
            }
            if (!feof($file)) {
                echo "Error: unexpected fgets() fail\n";
                Yii::app()->end();
            }
            fclose($file);
        }
    }

    public function actionPop2()
    {
        $file = fopen('F:\Xedant\YANDEX_POPULARITY.txt', 'r');
        $i = 0;

        if ($file) {
            $key = $this->nextKeyword();
            $start = false;
            while (($buffer = fgets($file)) !== false) {
                if ('алдюхов сергей викторович|12' == trim($buffer))
                    $start = true;
                if (!$start)
                    continue;

                $i++;

                $line = trim(ltrim($buffer));
                $parts = explode('|', $line);
                $last = '';
                foreach ($parts as $part)
                    $last = $part;
                $keyword = trim($parts[0]);
                //echo $keyword.'<br>';
                //$keyword = str_replace("ё", 'е', $keyword);

                $stat = $last;
                if (empty($last))
                    continue;

                $k = 0;
                //echo $key->name. '<br>';
                while (strcmp($keyword, $key->name) > 0) {
                    //echo $keyword . ' > ' . $key->name . '<br>';
                    $key = $this->nextKeyword();
                    $k++;
                    if ($k > 500){
                        //echo $keyword.'<br>';
                        //Yii::app()->end();
                        break;
                    }
                }

//                if ($k > 20000)
//                    echo ' k = '.$k.'<br>';

                if (strcmp($keyword, $key->name) == 0){
                    echo 'success '.$key->id.'  '.$key->name.'<br>';
                    Yii::app()->db_seo->createCommand('CALL saveYP (:key_id, :stat)')->execute(array(
                        ':key_id' => $key->id,
                        ':stat' => $stat,
                    ));
                }
            }
            if (!feof($file)) {
                echo "Error: unexpected fgets() fail\n";
                Yii::app()->end();
            }
            fclose($file);
        }
    }

    public function nextKeyword()
    {
        if ($this->j >= $this->limit || empty($this->keywords)) {
            $this->keywords = $this->getKeywords();
            $this->j = 0;
        }

        $result = $this->keywords[$this->j];
        $this->j++;

        return $result;
    }

    public function returnKey($k)
    {
         if ($this->j >= $k)
             $this->j = $this->j - $k;
        else{
            $this->i--;
            $this->j = $this->limit + $this->j - $k;
            $this->keywords = $this->getKeywords();
            $this->last_id = $this->keywords[$this->limit - 1]->id;
            //echo $this->last_id.'<br>';
        }
    }

    public function getKeywords()
    {
        $criteria = new CDbCriteria;
        //$criteria->condition = 'id >= 2227287';
        $criteria->condition = 'id > '.$this->last_id;
        $criteria->limit = $this->limit;
        $criteria->order = 'id';
        $percent = round($this->i * $this->limit / 2100000);
        if ($percent > $this->prev_percent) {
            $this->prev_percent = $percent;
            echo $percent . "% \n";
        }
        //echo 'достали еще '.$this->limit.'<br>';
        flush();

        return Keywords::model()->findAll($criteria);
    }

    private $i = 0;
    private $j = 0;
    private $keywords = array();
    private $limit = 10000;
    private $prev_percent = 0;
    private $last_id = 15016308;

    public function actionPop3(){
       echo  strcmp('аля', 'але');
    }

}