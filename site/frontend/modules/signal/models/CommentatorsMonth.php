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
     * @var array массив работавших комментаторов c их количеством баллов по всем премиях
     */
    public $commentators_rating = array();
    /**
     * @var array массив работавших комментаторов c их месячной статистикой по премиям
     */
    public $commentators_stats = array();
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
        $commentators = CommentatorHelper::getCommentatorIdList();

        $active_commentators = array();
        foreach ($commentators as $commentator) {
            $model = $this->getCommentator($commentator);
            if ($model !== null) {
                echo 'commentator: ' . $commentator . "\n";
                $active_commentators [] = $commentator;

                $views = $this->profileUniqueViews($commentator);
                $se = (int)$this->getSeVisits($commentator);
                $this->commentators_stats[(int)$commentator] = array(
                    self::NEW_FRIENDS => $model->friendsMonthStats($this->period),
                    self::PROFILE_VIEWS => $views,
                    self::IM_MESSAGES => $model->imMessagesMonthStats($this->period),
                    self::SE_VISITS => $se,
                );
                $this->commentators_rating[(int)$commentator] = array(
                    self::NEW_FRIENDS => $model->friends($this->period),
                    self::PROFILE_VIEWS => ($views['views'] + $views['visitors'] * 3),
                    self::IM_MESSAGES => $model->imMessages($this->period),
                    self::SE_VISITS => $se,
                );
                $model->calculateDayStats();
            }
        }

        //удаляем неактивных комментаторов
        foreach ($this->commentators_rating as $commentator_id => $val)
            if (!in_array($commentator_id, $active_commentators))
                unset($this->commentators_rating[$commentator_id]);

        $this->save();
    }

    /**
     * Возвращает модель комментатора по его id
     * Если не находит, возвращает null
     *
     * @param int $commentator_id id комментатора
     * @return CommentatorWork
     */
    public function getCommentator($commentator_id)
    {
        $criteria = new EMongoCriteria;
        $criteria->user_id('==', (int)$commentator_id);
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
        if (!isset($this->commentators_rating[$user_id]))
            return 99;

        $arr = array();
        foreach ($this->commentators_rating as $_user_id => $data)
            $arr[$_user_id] = $data[$counter];

        arsort($arr);
        $i = 1;
        foreach ($arr as $_user_id => $data) {
            if ($_user_id == $user_id || $data == $arr[$user_id]) {
                return $i;
            }
            $i++;
        }
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
        if ($place < 4)
            return '<div class="win-place win-place__' . $place . '"></div>';
        return '<div class="award-me_place-value">' . $place . '</div><div class="award-me_place-tx">место</div>';
    }

    /**
     * Вывод места в верстке у главного редактора
     *
     * @param $user_id int id комментатора
     * @param $counter int номер премии
     * @return string
     */
    public function getPlaceViewAdmin($user_id, $counter)
    {
        $place = $this->getPlace($user_id, $counter);
        if ($place < 4)
            return '<div class="win-place-3 win-place-3__' . $place . '"></div>';
        return '<div class="report-plan_place">
                <div class="report-plan_place-value">' . $place . '</div>
                <div class="report-plan_place-tx">место</div>
                </div>';
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
        if (!isset($this->commentators_rating[$user_id]))
            return 0;

        foreach ($this->commentators_rating as $_user_id => $data)
            if ($_user_id == $user_id)
                return $data[$counter];
        return 0;
    }

    /**
     * Возвращает кол-во баллов по премии у того кто занимает место $place
     * @param $place
     * @param $counter
     * @return array кол-во баллов по премии и id комментатора
     */
    public function getStatByPlace($place, $counter)
    {
        $arr = array();
        foreach ($this->commentators_rating as $_user_id => $data)
            $arr[$_user_id] = $data[$counter];

        arsort($arr);
        $i = 1;
        foreach ($arr as $_user_id => $data) {
            if ($i == $place) {
                return array($data, $_user_id);
            }
            $i++;
        }

        return array(0, 0);
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
        $visitors = GApi::model()->visitors('/user/' . $user_id . '/', $this->period . '-01');
        $views = GApi::model()->uniquePageviews('/user/' . $user_id . '/', $this->period . '-01');

        return array('visitors' => $visitors, 'views' => $views);
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

    public function prepareNewStats()
    {
        $commentators = CommentatorHelper::getCommentatorIdList();
        $days = range(1, date("d"));
        foreach ($commentators as $commentator) {
            echo $commentator."\n";
            $model = $this->getCommentator($commentator);
            foreach ($days as $day) {
                echo date("Y-m") . '-' . sprintf('%02d', $day) . "\n";
                $model->calculateDayStats(date("Y-m") . '-' . sprintf('%02d', $day));
            }
        }
    }
}
