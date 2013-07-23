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
     * Премия за личные сообщения
     */
    const IM_MESSAGES = 4;
    /**
     * Премия за наибольшее кол-во записей
     */
    const RECORDS_COUNT = 6;
    /**
     * Премия за пост, к которому написано наибольшее количество пользовательских комментариев
     */
    const MOST_COMMENTED_POST = 7;
    /**
     * Премия за наибольшее кол-во развернутых комментариев
     */
    const GOOD_COMMENTS_COUNT = 8;


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

                $this->commentators_stats[(int)$commentator] = array(
                    self::NEW_FRIENDS => $model->friendsMonthStats($this->period),
                    self::IM_MESSAGES => $model->imMessagesMonthStats($this->period),
                );
                $this->commentators_rating[(int)$commentator] = array(
                    self::NEW_FRIENDS => (int)$model->friends($this->period),
                    self::IM_MESSAGES => (int)$model->imMessages($this->period),
                    self::RECORDS_COUNT => (int)CommentatorHelper::recordsCount($commentator, $this->period),
                    self::MOST_COMMENTED_POST => (int)CommentatorHelper::maxCommentsCount($commentator, $this->period),
                    self::GOOD_COMMENTS_COUNT => (int)CommentatorHelper::goodCommentsCount($commentator, $this->period),
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
     * Возвращает кол-во баллов по премии для команды комментатора
     *
     * @param $user_id int id комментатора
     * @param $counter int номер премии
     * @return int кол-во баллов по премии для команды комментатора
     */
    public function getTeamStatValue($user_id, $counter)
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

    public function prepareNewStats()
    {
        $commentators = CommentatorHelper::getCommentatorIdList();
        $days = range(1, date("d") - 1);
        foreach ($commentators as $commentator) {
            echo $commentator . "\n";
            $model = $this->getCommentator($commentator);
            if ($model !== null) {
                foreach ($days as $day) {
                    echo date("Y-m") . '-' . sprintf('%02d', $day) . "\n";
                    $model->calculateDayStats(date("Y-m") . '-' . sprintf('%02d', $day));
                }
            }
        }
    }
}
