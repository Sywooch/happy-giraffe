<?php

/**
 * Class KeywordDirectRelation
 *
 * Хранения связей из wordstat между ключевыми словами
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class KeywordDirectRelation
{
    public $keyword_from_id;
    public $keyword_to_id;

    /**
     * @var KeywordDirectRelation
     */
    private static $_instance;

    /**
     * @return KeywordDirectRelation
     */
    public static function getInstance()
    {
        if (null === self::$_instance)
            self::$_instance = new self();
        return self::$_instance;
    }

    private function __construct()
    {
    }

    public function getCollection()
    {
        return $this->getMongoDBComponent()
    }

    /**
     * Соединение с базой данных
     * @return EMongoDB
     */
    public function getMongoDBComponent()
    {
        return Yii::app()->getComponent('mongodb_parsing');
    }

    /**
     * Сохранение связи "Что еще искали искавшие"
     * @param $keyword_from_id int
     * @param $keyword_to_id int
     */
    public static function saveRelation($keyword_from_id, $keyword_to_id)
    {
        $exist = Yii::app()->db_keywords->createCommand()
            ->select('keyword_from_id')
            ->from(self::model()->tableName())
            ->where('keyword_from_id=:keyword_from_id AND keyword_to_id=:keyword_to_id',
                array(
                    ':keyword_from_id' => $keyword_from_id,
                    ':keyword_to_id' => $keyword_to_id,
                ))
            ->queryScalar();

        if (empty($exist)) {
            try {
                Yii::app()->db_keywords->createCommand()
                    ->insert(self::model()->tableName(),
                        array(
                            'keyword_from_id' => $keyword_from_id,
                            'keyword_to_id' => $keyword_to_id,
                        ));
            } catch (Exception $err) {
            }
        }
    }
}