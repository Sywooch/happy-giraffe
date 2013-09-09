<?php
/**
 * Class CommentatorHelper
 *
 * Вспомогательный класс, включает в себя вычисление статистических данных комментаторов, таких как
 * количество личных сообщений, количество заходов из поисковиков и др.
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */

class CommentatorHelper
{
    /**
     * Лимит кол-ва символов в комментариях, меньше которого комментарии не учитываются
     */
    const COMMENT_LIMIT = 100;
    /**
     * Лимит кол-ва символов в хороших комментариях
     */
    const COMMENT_GOOD_LIMIT = 200;

    /**
     * Возвращает массив статистикой личных сообщения за период время от date1 до date2
     * массив имеет вид: array('out' => 0, 'in' => 0, 'users' => 0)
     * out - кол-во исходящих сообщений
     * in - кол-во входящих сообщений
     * interlocutors_in - количество написавших респондентов
     * interlocutors_out - количество получивших от комментатора сообщения респондентов
     *
     * @param $user_id int id пользователя, для которого нужна статистка
     * @param $date1 string дата начала периода за который вычисляем статистку
     * @param $date2 null|string дата конца периода за который вычисляем статистку, если null то вычисляем статистику
     * за один день $date1
     * @return array массив со статистикой
     */
    public static function imStats($user_id, $date1, $date2 = null)
    {
        if (empty($date2))
            $date2 = $date1;

        //выбираем все диалоги пользователя, в которых были написано сообщения в указанный период времени
        $dialogs = MessagingThread::model()->findAll(array(
            'with' => array(
                'threadUsers' => array(
                    'condition' => 'threadUsers.user_id = ' . $user_id,
                ),
                'messages' => array(
                    'condition' => 'messages.created >= :min AND messages.created <= :max',
                    'params' => array(
                        ':min' => $date1 . ' 00:00:00',
                        ':max' => $date2 . ' 23:59:59'
                    )
                ),
                'together' => true
            )
        ));

        $stats = array('out' => 0, 'in' => 0, 'interlocutors_in' => 0, 'interlocutors_out' => 0);
        //считает показатели в выбранных диалогах
        foreach ($dialogs as $dialog) {
            //если переписка ведется с простым пользователем
            if ($dialog->withSimpleUser()) {
                $in = false;
                $out = false;
                foreach ($dialog->messages as $message)
                    if ($message->author_id == $user_id) {
                        $out = true;
                        $stats['out']++;
                    } else {
                        $stats['in']++;
                        $in = true;
                    }

                if ($in)
                    $stats['interlocutors_in']++;
                if ($out)
                    $stats['interlocutors_out']++;
            }
        }

        return $stats;
    }

    /**
     * Вычисление рейтинга по сообщениям по формуле
     * ((Кол-во входящих сообщений) + (Кол-во исходящих сообщений)*0.2) * 1.01^(количество ответивших респондентов)
     * @param $user_id int id пользователя
     * @param $date1 string дата начала периода за который вычисляем
     * @param $date2 null|string дата конца периода за который вычисляем, если null то вычисляем статистику
     * за один день $date1
     * @return int кол-во баллов за личные сообщения
     */
    public static function imRating($user_id, $date1, $date2 = null)
    {
        $stat = self::imStats($user_id, $date1, $date2);

        return round(($stat['in'] + $stat['out'] * 0.2) * pow(1.01, $stat['interlocutors_in']));
    }

    /**
     * Вычисляет статистику друзей, возвращает массив в котором
     * 'requests' => кол-во заявок в друзья,
     * 'friends' => кол-во друзей,
     * @param $user_id int id пользователя
     * @param $date1 дата начала периода за который вычисляем
     * @param $date2 null|string дата конца периода за который вычисляем, если null то вычисляем статистику
     * за один день $date1
     * @return array массив со статистикой друзей
     */
    public static function friendStats($user_id, $date1, $date2 = null)
    {
        if (empty($date2))
            $date2 = $date1;

        return array(
            'requests' => self::friendRequestsCount($user_id, $date1, $date2),
            'friends' => self::friendsCount($user_id, $date1, $date2),
        );
    }

    /**
     * Возвращает количество новых друзей за период времени
     *
     * @param $user_id int id пользователя
     * @param $date1 дата начала периода за который вычисляем
     * @param $date2 дата конца периода за который вычисляем
     * @return string количество новых друзей
     */
    public static function friendsCount($user_id, $date1, $date2)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'user_id = :user_id AND created >= :min AND created <= :max ';
        $criteria->params = array(
            ':user_id' => $user_id,
            ':min' => $date1 . ' 00:00:00',
            ':max' => $date2 . ' 23:59:59'
        );
        return Friend::model()->count($criteria);
    }

    /**
     * Возвращает количество заявок пользователя на добавление в друзья за период времени
     *
     * @param $user_id int id пользователя
     * @param $date1 дата начала периода за который вычисляем
     * @param $date2 дата конца периода за который вычисляем
     * @return string количество заявок
     */
    public static function friendRequestsCount($user_id, $date1, $date2)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'from_id = :user_id AND created >= :min AND created <= :max ';
        $criteria->params = array(
            ':user_id' => $user_id,
            ':min' => $date1 . ' 00:00:00',
            ':max' => $date2 . ' 23:59:59'
        );
        return FriendRequest::model()->count($criteria);
    }

    /**
     * Кол-во записей в блог и клуб за месяц
     * @param int $user_id id пользователя
     * @param string $month год и месяц за который считаем
     * @return int
     */
    public static function recordsCount($user_id, $month)
    {
        return CommunityContent::model()->resetScope()->count(
            'author_id=:author_id AND created >= :start_time AND created <= :end_time AND removed=0',
            array(
                'author_id' => $user_id,
                ':start_time' => $month . '-01 00:00:00',
                ':end_time' => $month . '-31 23:59:59',
            )
        );
    }

    /**
     * Масимальное кол-во комментариев к посту за месяц
     * @param int $user_id id пользователя
     * @param string $month год и месяц за который считаем
     * @return int
     */
    public static function maxCommentsCount($user_id, $month)
    {
        $recordIds = Yii::app()->db->createCommand()
            ->select('id')
            ->from('community__contents')
            ->where('author_id=:author_id AND created >= :start_time AND created <= :end_time AND removed=0',
                array(
                    'author_id' => $user_id,
                    ':start_time' => $month . '-01 00:00:00',
                    ':end_time' => $month . '-31 23:59:59',
                )
            )->queryColumn();

        $max = 0;
        foreach ($recordIds as $recordId) {
            $comments_count = Comment::model()->count('(entity="BlogContent" OR entity="CommunityContent") AND entity_id=:id',
                array(':id' => $recordId));
            if ($comments_count > $max)
                $max = $comments_count;
        }

        return $max;
    }

    /**
     * Кол-во развернутых комментариев за месяц
     * @param int $user_id id пользователя
     * @param string $month год и месяц за который считаем
     * @return int
     */
    public static function goodCommentsCount($user_id, $month)
    {
        $texts = Yii::app()->db->createCommand()
            ->select('text')
            ->from('comments')
            ->where('author_id=:author_id AND created >= :start_time AND created <= :end_time AND removed=0',
                array(
                    'author_id' => $user_id,
                    ':start_time' => $month . '-01 00:00:00',
                    ':end_time' => $month . '-31 23:59:59',
                )
            )->queryColumn();

        $count = 0;
        foreach ($texts as $text) {
            $length = Str::htmlTextLength($text);
            if ($length >= self::COMMENT_GOOD_LIMIT)
                $count++;
        }

        return $count;
    }

    /**
     * Возвращает список id комментаторов. Кэширует на час
     * @return array
     */
    public static function getCommentatorIdList()
    {
        $cache_id = 'commentators_id_list';
        $value = Yii::app()->cache->get($cache_id);
        if ($value === false) {
            $ids = Yii::app()->db->createCommand()
                ->selectDistinct('id')
                ->from('users')
                ->where('`group`=' . UserGroup::COMMENTATOR)
                ->queryColumn();

            $value = array();
            foreach ($ids as $id) {
                $exist = Yii::app()->db->createCommand()
                    ->select('userid')
                    ->from('auth__assignments')
                    ->where('userid = :user_id AND itemname="commentator"', array(':user_id' => $id))
                    ->queryScalar();
                if (!empty($exist))
                    $value[] = $id;
            }

            Yii::app()->cache->set($cache_id, $value, 1000);
        }

        return $value;
    }

    public static function getCommentatorsData()
    {
        $users = User::model()->findAll('`group`=' . UserGroup::COMMENTATOR);
        $data = array();
        foreach ($users as $user)
            $data[$user->id] = array(
                'id' => $user->id,
                'name' => $user->fullName,
                'ava' => SeoUser::getAvatarUrlForUser($user, 24),
            );

        return $data;
    }
}