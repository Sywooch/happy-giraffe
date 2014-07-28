<?php
/**
 * class ViewedPost
 *
 * Просмотры постов в ленте пользователем. Нужен чтобы показывать сколько новых
 * постов в ленте. Работает следующим образом: запоминает id статьи, меньше которого
 * прочитаны все статьи; и массив id прочитанных статей больше этого. После прочтения еще статей проверяет
 * изменился ли минимальный id статьи, чтобы хранить меньше данных.
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ViewedPost extends HMongoModel
{
    public function attributeNames()
    {
        return array();
    }

    protected $_collection_name = 'user_subscription_views';

    /**
     * @var ViewedPost
     */
    private static $_instance;
    /**
     * @var int
     */
    public $user_id;
    /**
     * @var int
     */
    public $min_id;
    /**
     * @var int[]
     */
    public $viewed_ids;

    /**
     * @param int|null $user_id
     * @return ViewedPost
     */
    public static function getInstance($user_id = null)
    {
        if (empty($user_id))
            $user_id = Yii::app()->user->id;

        if (null === self::$_instance)
            self::$_instance = new self($user_id);

        return self::$_instance;
    }

    /**
     * @param $user_id
     */
    private function __construct($user_id)
    {
        $data = $this->getCollection()->findOne(array(
            'user_id' => (int)$user_id,
        ));
        if (empty($data)) {
            $this->initUser(Yii::app()->user->id);
            $data = $this->getCollection()->findOne(array(
                'user_id' => (int)$user_id,
            ));

        }
        $this->_id = $data['_id'];
        $this->user_id = $data['user_id'];
        $this->min_id = $data['min_id'];
        $this->viewed_ids = $data['viewed_ids'];
    }

    /**
     * Инициализация при регистрации пользователя
     *
     * @param int $user_id
     */
    public function initUser($user_id)
    {
        $min_id = Yii::app()->db->createCommand()
            ->select('id')
            ->from('community__contents')
            ->order('id desc')
            ->queryScalar();
        $this->createInitModel(array($min_id), $user_id);
    }

    /**
     * добавить модель для учета просмотров
     *
     * @param int[] $ids id статей
     * @param int $user_id id пользователя
     */
    private function createInitModel($ids, $user_id)
    {
        $this->getCollection()->insert(array(
            'user_id' => (int)$user_id,
            'min_id' => (int)max($ids),
            'viewed_ids' => array()
        ));
    }

    /**
     * Индексы
     */
    public function ensureIndexes()
    {
        $this->getCollection()->ensureIndex(array(
            'type' => EMongoCriteria::SORT_DESC,
            'user_id' => EMongoCriteria::SORT_DESC,
            'param' => EMongoCriteria::SORT_DESC,
        ), array('name' => 'index'));

        $this->getCollection()->ensureIndex(array(
            'user_id' => EMongoCriteria::SORT_DESC,
        ), array('name' => 'user'));
    }

    /**
     * @param int $id
     * @return bool
     */
    public function isViewed($id)
    {
        return !in_array($id, $this->viewed_ids) && $id > $this->min_id;
    }

    /**
     * Возвращает количество непрочитанных постов
     *
     * @param int $user_id
     * @param int $type
     * @param int|null $param
     * @return int
     */
    public function newPostCount($user_id, $type, $param = null)
    {
        $dp = SubscribeDataProvider::getDataProvider($user_id, $type, $param);
        $dp->criteria->addCondition('t.id > :min_id');
        $dp->criteria->addNotInCondition('t.id', $this->viewed_ids);
        $dp->criteria->params[':min_id'] = $this->min_id;

        $count = CommunityContent::model()->count($dp->criteria);
        return $count;
    }

    /**
     * Добавить просмотренные записи в список
     *
     * @param CommunityContent[] $models статьи
     */
    public function addViews($models)
    {
        $ids = array();
        foreach ($models as $model)
            $ids[] = (int)$model->id;

        $this->addMoreViews($ids);
    }

    /**
     * Добавляет id прочитанных пользователем постов для данного фильтра (блога, сообщества, друзей)
     * Также пересчитывает минимальный id
     *
     * @param int[] $ids
     */
    private function addMoreViews($ids)
    {
        foreach ($ids as $id)
            if (!in_array($id, $this->viewed_ids) && $id > $this->min_id)
                $this->viewed_ids [] = $id;

        $min_ads = $this->getMinimumIds();
        $this->findNewMinId($min_ads);

        $this->removeExcessIds();
        $this->getCollection()->update(
            array('_id' => $this->_id),
            array('$set' => array('min_id' => $this->min_id, 'viewed_ids' => $this->viewed_ids))
        );
        $this->ensureIndexes();
    }

    /**
     * Возвращает 100 самых меньших id постов, id которых больше минимального
     *
     * @return array
     */
    private function getMinimumIds()
    {
        $dp = SubscribeDataProvider::getDataProvider($this->user_id, SubscribeDataProvider::TYPE_ALL);
        $dp->criteria->select = array('t.id');
        $dp->criteria->addCondition('t.id > :min_id');
        $dp->criteria->order = 't.id asc';
        $dp->criteria->limit = 100;
        $dp->criteria->params[':min_id'] = $this->min_id;
        $contents = CommunityContent::model()->findAll($dp->criteria);
        $min_ads = array();
        foreach ($contents as $content)
            $min_ads [] = (int)$content->id;
        sort($min_ads);

        return $min_ads;
    }

    /**
     * Находит минимальный id
     * @param int[] $min_ads
     */
    private function findNewMinId($min_ads)
    {
        foreach ($min_ads as $id) {
            if (in_array($id, $this->viewed_ids))
                $this->min_id = $id;
            else break;
        }
    }

    /**
     * Удаляет избыточные id из массива
     */
    private function removeExcessIds()
    {
        foreach ($this->viewed_ids as $key => $readId)
            if ($readId < $this->min_id)
                unset($this->viewed_ids[$key]);
    }
}