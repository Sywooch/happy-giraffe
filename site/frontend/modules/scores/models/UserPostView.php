<?php
/**
 * class PostView
 *
 * Просмотры постов пользователем
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class UserPostView extends HMongoModel
{
    protected $_collection_name = 'user_page_views';

    /**
     * @var UserPostView
     */
    private static $_instance;

    /**
     * @return UserPostView
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
            'id' => EMongoCriteria::SORT_DESC,
            'user_id' => EMongoCriteria::SORT_DESC,
        ), array('name' => 'user_view'));

        $this->getCollection()->ensureIndex(array(
            'user_id' => EMongoCriteria::SORT_DESC,
        ), array('name' => 'user'));
    }

    /**
     * Проверить просматривал ли пользователь запись, если нет то добавить
     * просмотр записи и проверить на достижение
     *
     * @param int $user_id id пользователя
     * @param int $id id статьи
     */
    public function checkView($user_id, $id)
    {
        $exist = $this->getCollection()->findOne(array(
            'user_id' => (int)$user_id,
            'id' => (int)$id,
        ));
        if (empty($exist))
            $this->addView($user_id, $id);
    }

    /**
     * добавить просмотр записи и проверить на достижение
     *
     * @param int $user_id id пользователя
     * @param int $id id статьи
     */
    private function addView($user_id, $id)
    {
        $this->ensureIndexes();
        $r = $this->getCollection()->insert(array(
            'user_id' => (int)$user_id,
            'id' => (int)$id,
        ));

        ScoreAchievement::model()->checkAchieve($user_id, ScoreAchievement::TYPE_VIEWS);
    }

    /**
     * Кол-во просмотренных пользователем статей
     *
     * @param int $user_id id пользователя
     * @return int
     */
    public function count($user_id)
    {
        return $this->getCollection()->count(array('user_id' => (int)$user_id));
    }
}