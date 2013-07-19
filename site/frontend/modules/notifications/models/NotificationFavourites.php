<?php
/**
 * Class NotificationFavourites
 *
 * Уведомление пользователю об избранном
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class NotificationFavourites extends Notification
{
    /**
     * @var NotificationFavourites
     */
    private static $_instance;
    public $type = self::NEW_FAVOURITE;
    /**
     * топ-10 избранных статей за день, вида:
     * 'entity' => класс статьи,
     * 'entity_id' => id статьи,
     * 'count' => суммарное кол-во добавлений в избранное
     *
     * @var array
     */
    public $articles = array();

    public function __construct()
    {
    }

    /**
     * Создаение уведомления о новом избранном. Раз в день в 10 утра
     *
     * @param int $recipient_id
     * @param array $articles топ-статьи по добавлению в избранное
     * @param int $count суммарное кол-во добавлений в избранное
     */
    public function create($recipient_id, $articles, $count)
    {
        $this->recipient_id = (int)$recipient_id;
        $this->insert(array(
            'articles' => $articles,
            'count' => (int)$count
        ));
    }

    /**
     * @return NotificationFavourites
     */
    public static function model()
    {
        if (null === self::$_instance)
            self::$_instance = new self();
        return self::$_instance;
    }

    /**
     * Создает модель уведомления для удобой работы с ним
     *
     * @param $object array объект, который вернул компонент работы с базой
     * @return NotificationFavourites
     */
    public static function createModel($object)
    {
        $model = new NotificationFavourites();
        foreach ($object as $key => $value)
            $model->$key = $value;

        return $model;
    }
}