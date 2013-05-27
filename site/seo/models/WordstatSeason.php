<?php

/**
 * Class WordstatSeason
 *
 * Хранение сезонности вордстат
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class WordstatSeason extends HMongoModel
{
    protected $_collection_name = 'keywords_season';

    public $keyword_id;
    public $month;
    public $year;
    public $value;

    /**
     * @var WordstatSeason
     */
    private static $_instance;

    /**
     * @return WordstatSeason
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    private function __construct()
    {
    }

    private function ensureIndexes()
    {
        $this->getCollection()->ensureIndex(array(
            'keyword_id' => EMongoCriteria::SORT_DESC,
        ), array('name' => 'keyword_index'));

        $this->getCollection()->ensureIndex(array(
            'keyword_id' => EMongoCriteria::SORT_DESC,
            'month' => EMongoCriteria::SORT_ASC,
            'year' => EMongoCriteria::SORT_ASC,
        ), array('name' => 'date_index'));
    }

    public function add($keyword_id, $year, $month, $value)
    {
        $this->ensureIndexes();
        $this->getCollection()->insert(array(
            'keyword_id' => (int)$keyword_id,
            'year' => (int)$year,
            'month' => (int)$month,
            'value' => (int)$value,
        ));
    }
}