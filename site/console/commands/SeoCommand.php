<?php
/**
 * Author: alexk984
 * Date: 13.03.12
 */
class SeoCommand extends CConsoleCommand
{
    private $i = 0;
    private $j = 0;
    private $keywords = array();
    private $limit = 10000;
    private $prev_percent = 0;

    public function actionIndex($thread = 1)
    {
        $this->Popularity($thread);
    }

    public function Popularity($thread)
    {
        Yii::import('site.seo.models.*');
        Yii::import('site.seo.components.*');
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');

        $file = fopen('F:\Xedant\YANDEX_POPULARITY.txt', 'r');
//        $file = fopen('/var/temporary/YANDEX_POPULARITY.txt', 'r');

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

    public function ypop()
    {
        $file = fopen('F:\Xedant\YANDEX_POPULARITY.txt', 'r');
        $i = 0;

        if ($file) {
            $key = $this->nextKeyword();

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

                $stat = $last;
                if (empty($last))
                    continue;

                $k = 0;
                while (strcmp($keyword, $key->name) > 0) {
                    //echo $keyword . ' > ' . $key->name . '<br>';
                    $key = $this->nextKeyword();
                    if ($k > 100)
                        break;
                    $k++;
                }

                if (strcmp($keyword, $key->name) == 0)
                    Yii::app()->db_seo->createCommand('CALL saveYP (:key_id, :stat)')->execute(array(
                        ':key_id' => $key->id,
                        ':stat' => $stat,
                    ));
                $i++;
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

    public function getKeywords()
    {
        $criteria = new CDbCriteria;
        //$criteria->condition = 'id >= 2227287';
        $criteria->condition = 'id > 50000000';
        $criteria->limit = $this->limit;
        $criteria->offset = $this->limit * $this->i;
        $criteria->order = 'id';
        $this->i++;
        $percent = round($this->i * $this->limit / 2100000);
        if ($percent > $this->prev_percent) {
            $this->prev_percent = $percent;
            echo $percent . "% \n";
        }
        //echo 'достали еще '.$this->limit.'<br>';
        flush();

        return Keywords::model()->findAll($criteria);
    }
}

