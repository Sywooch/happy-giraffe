<?php
/**
 * Class CommentatorsMonth
 *
 * Статистика комментаторов за месяц. Хранят сводные данные по премиям, список работавших комментаторов
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class CommentatorsMonth extends EMongoDocument
{
    /**
     * Премия за друзей
     */
    const NEW_FRIENDS = 1;
    /**
     * Премия за посещение анкеты
     */
    const PROFILE_VIEWS = 3;
    /**
     * Премия за личные сообщения
     */
    const IM_MESSAGES = 4;
    /**
     * Премия за заходы из поисковых систем
     */
    const SE_VISITS = 5;

    /**
     * @var string строковое представление месяца, например 2013-02
     */
    public $period;
    /**
     * @var array список работавших комментаторов
     */
    public $commentators = array();
    /**
     * @var int количество рабочих дней в месяце
     */
    public $working_days_count = 22;

    /**
     * @param string $className
     * @return CommentatorsMonth
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string название коллекции
     */
    public function getCollectionName()
    {
        return 'commentators_month_stats';
    }

    /**
     * Переопределяем первичный ключ
     * @return string первичный ключ
     */
    public function primaryKey()
    {
        return 'period';
    }

    /**
     * Соединение с базой данных
     * @return EMongoDB
     */
    public function getMongoDBComponent()
    {
        return Yii::app()->getComponent('mongodb_production');
    }

    /**
     * Возвращает модель CommentatorsMonth для указанного месяца, создает если периода нет
     *
     * @static
     * @param string $period месяц, для которго ищем модель формата YYYY-MM
     * @return CommentatorsMonth
     */
    public static function get($period = null)
    {
        if (empty($period))
            $period = date("Y-m");

        $month = self::model()->findByPk($period);
        if ($month === null && $period == date("Y-m")) {
            $month = new CommentatorsMonth;
            $month->period = date("Y-m");
            $month->save();
        }

        return $month;
    }

    /**
     * Для каждого комментатора вычисляет кол-во баллов по всем премиям за месяц
     * Удаляет уволенных комментаторов, если такие есть
     * Запускается по крону раз в час
     */
    public function calculateMonth()
    {
        $commentators = User::model()->findAll('`group`=' . UserGroup::COMMENTATOR);

        $active_commentators = array();
        foreach ($commentators as $commentator) {
            $model = $this->getCommentator($commentator);
            if ($model !== null) {
                //echo 'commentator: ' . $commentator->id . "\n";
                $active_commentators [] = $commentator->id;

                $this->commentators[(int)$commentator->id] = array(
                    self::NEW_FRIENDS => (int)$model->newFriends($this->period),
                    self::PROFILE_VIEWS => (int)$model->imMessages($this->period),
                    self::IM_MESSAGES => (int)$this->profileUniqueViews($commentator->id),
                    self::SE_VISITS => (int)$this->getSeVisits($commentator->id),
                );
                $this->save();
            }
        }

        //удаляем неактивных комментаторов
        foreach ($this->commentators as $commentator_id => $val)
            if (!in_array($commentator_id, $active_commentators))
                unset($this->commentators[$commentator_id]);

        $this->save();
    }

    /**
     * Возвращает модель комментатора по его id
     * Если не находит, возвращает null
     *
     * @param User|null $commentator комментатор
     * @return CommentatorWork
     */
    public function getCommentator($commentator)
    {
        $criteria = new EMongoCriteria;
        $criteria->user_id('==', (int)$commentator->id);
        $model = CommentatorWork::model()->find($criteria);
        if ($model === null || $model->isNotWorkingAlready())
            return null;

        return $model;
    }

    /**
     * Вычисляет место по премии занимаемое комментатором
     *
     * @param $user_id int id комментатора
     * @param $counter int номер премии
     * @return int место в рейтинге занимаемое комментатором
     */
    public function getPlace($user_id, $counter)
    {
        if (!isset($this->commentators[$user_id]))
            return 0;

        $arr = array();
        foreach ($this->commentators as $_user_id => $data)
            $arr[$_user_id] = $data[$counter];

        arsort($arr);
        $i = 1;
        foreach ($arr as $_user_id => $data) {
            if ($_user_id == $user_id || $data == $arr[$user_id]) {
                if ($data == 0)
                    return 0;
                return $i;
            }
            $i++;
        }

        return 0;
    }

    /**
     * Вывод места в верстке
     *
     * @param $user_id int id комментатора
     * @param $counter int номер премии
     * @return string
     */
    public function getPlaceView($user_id, $counter)
    {
        $place = $this->getPlace($user_id, $counter);
        if ($place == 0) {
            return '<span class="place"></span>';
        } elseif ($place < 4)
            return '<span class="place place-' . $place . '">' . $place . ' место</span>';
        return '<span class="place">' . $place . ' место</span>';
    }

    /**
     * Возвращает кол-во баллов по премии для комментатора
     *
     * @param $user_id int id комментатора
     * @param $counter int номер премии
     * @return int кол-во баллов по премии для комментатора
     */
    public function getStatValue($user_id, $counter)
    {
        if (!isset($this->commentators[$user_id]))
            return 0;

        foreach ($this->commentators as $_user_id => $data)
            if ($_user_id == $user_id)
                return $data[$counter];
        return 0;
    }

    /**
     * Возвращает все рабочие месяца
     *
     * @return CommentatorsMonth[] рабочие месяца
     */
    public static function getMonths()
    {
        $result = array();
        $models = CommentatorsMonth::model()->findAll();
        foreach ($models as $model) {
            $result[] = $model->period;
        }

        return array_reverse($result);
    }

    /**
     * Возвращает количество просмотров анкеты комментатора за месяц
     *
     * @param $user_id int id комментатора
     * @return int количество просмотров анкеты
     */
    public function profileUniqueViews($user_id)
    {
        return GApi::model()->uniquePageviews('/user/' . $user_id . '/', $this->period . '-01');
    }

    /**
     * Возвращает количество поисковых заходов на все статьи комментатора за месяц
     *
     * @param $user_id int id комментатора
     * @return int количество поисковых заходов
     */
    public function getSeVisits($user_id)
    {
        $models = CommunityContent::model()->findAll('author_id = ' . $user_id);

        $all_count = 0;
        foreach ($models as $model) {
            $url = trim($model->url, '.');
            if (!empty($url)) {
                $visits = SearchEngineVisits::getVisits($url, $this->period);
                $all_count += $visits;
            }
        }

        echo $all_count . "\n";
        return $all_count;
    }

    /**
     * Количество поисковых заходов на страницу за месяц
     *
     * @param $url string url для которого ищем количество заходов
     * @return int Количество поисковых заходов на страницу за месяц
     */
    public function getPageVisitsCount($url)
    {
        return SearchEngineVisits::getVisits($url, $this->period);
    }

    /**
     * Синхронизация кол-ва заходов из поисковиков по своей системе с кол-вом заходов с Google Analytics
     */
    public function SyncGaVisits()
    {
        $month = date("Y-m");
        $commentators = CommentatorWork::getWorkingCommentators();

        foreach ($commentators as $commentator) {
            $models = CommunityContent::model()->findAll('author_id = ' . $commentator->user_id);

            foreach ($models as $model) {
                $url = trim($model->url, '.');
                if (!empty($url)) {
                    $ga_visits = GApi::model()->organicSearches($url, $month . '-01', null, false);
                    $my_visits = SearchEngineVisits::getVisits($url, $month);

                    if ($ga_visits > 0)
                        echo "$url ga:$ga_visits, my:$my_visits \n";

                    if ($ga_visits > 0 && $my_visits != $ga_visits) {
                        SearchEngineVisits::updateStats($url, $month, $ga_visits);
                    }
                }
            }
        }
    }
}
