<?php

/**
 * This is the model class for table "parsing_positions".
 *
 * The followings are the available columns in table 'parsing_positions':
 * @property integer $keyword_id
 * @property integer $active
 * @property integer $yandex
 * @property integer $google
 *
 * The followings are the available model relations:
 * @property Keyword $keyword
 */
class ParsingPosition extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ParsingPosition the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return CDbConnection database connection
     */
    public function getDbConnection()
    {
        return Yii::app()->db_seo;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'parsing_positions';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('keyword_id', 'numerical', 'integerOnly' => true),
            array('keyword_id, active, yandex, google', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'keyword' => array(self::BELONGS_TO, 'Keyword', 'keyword_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'keyword_id' => 'Keyword',
            'active' => 'Active',
            'yandex' => 'Yandex',
            'google' => 'Google',
        );
    }

    public static function collectKeywords()
    {
        //берем кейворды по которым заходили за последние 4 недели
        $keywords = Yii::app()->db_seo->createCommand()
            ->select('distinct(keyword_id)')
            ->from('queries')
            ->where('date >= :date AND visits > 1', array(':date' => date("Y-m-d", strtotime('-7 days'))))
            ->queryColumn();

        echo count($keywords) . "\n";
        foreach ($keywords as $keyword) {
            $p = new ParsingPosition;
            $p->keyword_id = $keyword;
            try {
                $p->save();
            } catch (Exception $err) {

            }
        }
    }

    public function testCollectKeywords()
    {
        //берем кейворды по которым заходили за последний месяц прямо из метрики
        $next = 'http://api-metrika.yandex.ru/stat/sources/phrases?id=11221648&oauth_token=b1cb78403f76432b8a6803dc5e6631b5&per_page=1000&date1=20130212&date2=20130312';

        $keywords = array();
        while (!empty($next)) {
            $val = $this->loadPage($next);
            $next = $this->getNextLink($val);

            foreach ($val['data'] as $query) {
                $keyword = Keyword::GetKeyword($query['phrase']);

                if ($keyword !== null) {
                    $keywords [] = $keyword->id;
                    $p = new ParsingPosition;
                    $p->keyword_id = $keyword->id;
                    try {
                        $p->save();
                    } catch (Exception $e) {
                    }
                }

                if ($query['visits'] <= 20)
                    break(2);
            }
            echo count($keywords) . "\n";
        }
    }

    public function getNextLink($val)
    {
        if (isset($val['links']['next']))
            $next = $val['links']['next'].'&per_page=1000';
        else
            $next = null;

        return $next;
    }

    public function loadPage($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/x-yametrika+json'));
        curl_exec($ch);
        $result = curl_exec($ch);
        curl_close($ch);
        sleep(2);
        return json_decode($result, true);
    }


    public static function collectPagesKeywords()
    {
        //берем кейворды по которым заходили за последние 4 недели
        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->offset = 0;

        $keywords = array();

        $i = 0;
        $models = array(0);
        while (!empty($models)) {
            $models = Page::model()->with('keywordGroup', 'keywordGroup.keywords')->findAll($criteria);

            foreach ($models as $model)
                if (!empty($model->keywordGroup))
                    foreach ($model->keywordGroup->keywords as $keyword)
                        $keywords[] = $keyword->id;

            $i++;
            $criteria->offset = $i * 100;
        }

        $keywords = array_unique($keywords);
        foreach ($keywords as $keyword) {
            $p = new ParsingPosition;
            $p->keyword_id = $keyword;
            $p->save();
        }
    }
}