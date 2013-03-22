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
     * Возвращает массив статистикой личных сообщения за период время от date1 до date2
     * массив имеет вид: array('out' => 0, 'in' => 0, 'users' => 0)
     * out - кол-во исходящих сообщений
     * in - кол-во входящих сообщений
     * users - кол-во респондентов (ответивших пользователю)
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
        $dialogs = Dialog::model()->findAll(array(
            'with' => array(
                'dialogUsers' => array(
                    'condition' => 'dialogUsers.user_id = ' . $user_id,
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

        $stats = array('out' => 0, 'in' => 0, 'users' => 0);
        //считает показатели в выбранных диалогах
        foreach ($dialogs as $dialog) {
            //если переписка ведется с простым пользователем
            if ($dialog->withSimpleUser()) {
                $user_answered = false;
                foreach ($dialog->messages as $message)
                    if ($message->user_id == $user_id)
                        $stats['out']++;
                    else {
                        $stats['in']++;
                        $user_answered = true;
                    }

                if ($user_answered)
                    $stats['users']++;
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

        return round(($stat['in'] + $stat['out'] * 0.2) * pow(1.01, $stat['users']));
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
        $stats = array('requests' => 0, 'friends' => 0);

        //вычисляем кол-во друзей
        $criteria = new CDbCriteria;
        $criteria->condition = '(user1_id = :user_id OR user2_id = :user_id) AND created >= :min AND created <= :max ';
        $criteria->params = array(
            ':user_id' => $user_id,
            ':min' => $date1 . ' 00:00:00',
            ':max' => $date2 . ' 23:59:59'
        );
        $stats['friends'] = Friend::model()->count($criteria);

        //вычисляем кол-во заявок
        $criteria = new CDbCriteria;
        $criteria->condition = 'from_id = :user_id AND created >= :min AND created <= :max ';
        $criteria->params = array(
            ':user_id' => $user_id,
            ':min' => $date1 . ' 00:00:00',
            ':max' => $date2 . ' 23:59:59'
        );
        $stats['requests'] = FriendRequest::model()->count($criteria);

        return $stats;
    }

    /**
     * Вычисляет статистику посещения анкеты пользователя, возвращает массив в котором
     * 'main' => посещений профиля
     * 'blog' => количество посещений блога
     * 'photo' => количество посещений фотогалерей
     * 'visits' => количество просмотров всех разделов
     * 'visitors' => количество поситителей
     * @param $user_id
     * @param $date1
     * @param null $date2
     * @return array массив со статистикой посещения анкеты
     */
    public static function visits($user_id, $date1, $date2 = null)
    {
        $stats = array('main' => 0, 'blog' => 0, 'photo' => 0, 'visits' => 0, 'visitors' => 0);
        $stats['main'] = GApi::model()->uniquePageviews('/user/' . $user_id . '/', $date1, $date2, false);
        $stats['blog'] = GApi::model()->uniquePageviews('/user/' . $user_id . '/blog/', $date1, $date2);
        $stats['photo'] = GApi::model()->uniquePageviews('/user/' . $user_id . '/albums/', $date1, $date2);
        $stats['visits'] = GApi::model()->uniquePageviews('/user/' . $user_id . '/', $date1, $date2);
        $stats['visits'] = GApi::model()->visitors('/user/' . $user_id . '/', $date1, $date2);

        return $stats;
    }
}