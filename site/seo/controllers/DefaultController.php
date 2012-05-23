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
            $key_stat->setAttribute('m'.$stat->month, $stat->value);
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
            while (($buffer = fgets($file)) !== false) {
                $i++;
                $line = trim(ltrim($buffer));
                $parts = explode('|', $line);
                $last = '';
                foreach ($parts as $part)
                    $last = $part;
                $keyword = trim($parts[0]);

                $keyword = trim(ltrim($keyword, '#'));
                $keyword = str_replace("'", '', $keyword);
                $keyword = str_replace("\\", '', $keyword);

                //$keyword = str_replace('$', '', $keyword);
                $stat = $last;
                if (empty($last))
                    continue;

                $key = $this->nextKeyword();
                while ($keyword != $key->name) {
                    //echo 'skip '.$keyword.'<br>';
                    $key = $this->nextKeyword();
                    $this->fail_long++;
                    if ($this->fail_long >= $this->limit)
                        break;
                }

                flush();
                if ($this->fail_long == $this->limit) {
                    $this->i = $this->i - 2;
                    $this->j--;
                    $this->keywords = $this->getKeywords();

                    //echo $keyword.' - not found, next keyword <br>';
                } else {
                    //echo 'success ' . $key->name . '<br>';

                    if ($key !== null && !empty($last)) {
                        Yii::app()->db_seo->createCommand('CALL saveYP (:key_id, :stat)')->execute(array(
                            ':key_id' => $key->id,
                            ':stat' => $stat,
                        ));
                    }
                }
                $this->fail_long = 0;
                $i++;
            }
            if (!feof($file)) {
                echo "Error: unexpected fgets() fail\n";
                Yii::app()->end();
            }
            fclose($file);
        }
    }

    private $i = 0;
    private $j = 0;
    private $keywords = array();
    private $fail_long = 0;
    private $limit = 100;

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

    public function getKeywords()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'id >= 2227287';
        $criteria->limit = $this->limit;
        $criteria->offset = $this->limit * $this->i;
        $criteria->order = 'id';
        $this->i++;

        return Keywords::model()->findAll($criteria);
    }
}