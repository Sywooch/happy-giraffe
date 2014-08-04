<?php
/**
 * Class ScoreVisits
 *
 * Модель для начисления баллов за заходы на сайт
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ScoreVisits extends HMongoModel
{
    public function attributeNames()
    {
        return array();
    }

    protected $_collection_name = 'score_visits';

    /**
     * @var int id пользователя
     */
    public $user_id;
    /**
     * @var string последний день посещения сайта
     */
    public $last_day;
    /**
     * @var int сколько дней подряд посещал сайт
     */
    public $longs;

    /**
     * @var ScoreVisits
     */
    private static $_instance;

    /**
     * @return ScoreVisits
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

    public function ensureIndexes()
    {
        $this->getCollection()->ensureIndex(array(
            'user_id' => EMongoCriteria::SORT_DESC,
        ), array('unique' => true, 'name' => 'user_id_index'));
    }

    /**
     * Поиск модели посещений пользователем
     *
     * @param $user_id
     * @return array|null
     */
    protected function find($user_id)
    {
        return $this->getCollection()->findOne(array('user_id' => (int)$user_id));
    }

    /**
     * Добавляем посещение сайта сегодня
     *
     * @param $user_id int id пользователя
     * @param null|string $day день посещения
     */
    public function addTodayVisit($user_id, $day = null)
    {
        if (empty($day))
            $day = date("Y-m-d");
        $model = $this->find($user_id);

        //если модели нет, значит зашел первый раз
        if (empty($model)) {
            $this->ensureIndexes();
            $this->getCollection()->insert(array(
                'user_id' => (int)$user_id,
                'last_day' => $day,
                'longs' => 1,
            ));
            //добавляем баллы
            ScoreInputVisit::getInstance()->add($user_id);
            return;
        }

        //если уже заходил сегодня выходим
        if ($day == $model['last_day'])
            return;

        if ($model['last_day'] == date("Y-m-d", strtotime('-1 day')))
            $model['longs']++;
        else
            $model['longs'] = 0;

        $this->getCollection()->update(
            array('_id' => $model['_id']),
            array('$set' => array('last_day' => $day)),
            array('$inc' => array('longs' => $model['longs']))
        );

        //добавляем баллы
        ScoreInputVisit::getInstance()->add($user_id);
        //проверяем на достижение
        ScoreAchievement::model()->checkAchieve($model['user_id'], ScoreAchievement::TYPE_VISITOR);
    }

    /**
     * Сколько дней подряд посетил сайт
     */
    public function daysCount($user_id)
    {
        $model = $this->find($user_id);
        return empty($model) ? 0 : $model['longs'];
    }

    public static function test($user_id)
    {

    }
}
