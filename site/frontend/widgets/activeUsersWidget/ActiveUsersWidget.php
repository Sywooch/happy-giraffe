<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/3/12
 * Time: 5:29 PM
 *
 * Для выбора первых 10 пользователей по рейтингу достаточно вытащить топ 10 пользователей из каждой категории
 */
class ActiveUsersWidget extends CWidget
{
    const LIMIT = 10;

    const TYPE_CLUBS = 0;
    const TYPE_BLOGS = 1;

    public $type;

    public function run()
    {
        $month = $this->getByMonth();
        $week = $this->getByWeek();
        $day = $this->getByDay();

        $usersIds = array();
        foreach ($month as $user_id => $m)
            $usersIds[] = $user_id;
        foreach ($week as $user_id => $w)
            $usersIds[] = $user_id;
        foreach ($day as $user_id => $d)
            $usersIds[] = $user_id;
        $usersIds = array_unique($usersIds);

        $criteria = new CDbCriteria(array(
            'with' => array(
                'avatar',
            ),
            'index' => 'id',
        ));
        $criteria->addInCondition('t.id', $usersIds);
        $users = User::model()->findAll($criteria);

        $this->render('index', compact('month', 'week', 'day', 'users'));
    }

    protected function getByMonth()
    {
        $from_time = date("Y-m").'-01 00:00:00';
        $result = $this->getTopUsers($from_time);

        return $result;
    }

    protected function getByWeek()
    {
        $from_time = date("Y-m-d", strtotime('Monday this week')).' 00:00:00';
        $result = $this->getTopUsers($from_time);

        return $result;
    }

    protected function getByDay()
    {
        $from_time = date("Y-m-d") . ' 00:00:00';
        $result = $this->getTopUsers($from_time);

        return $result;
    }

    public function getTopUsers($from_time)
    {
        $result = array();

        //calculate top 10
        $post_users = $this->getTopPostUsers($from_time);
        foreach ($post_users as $post_user)
            $result[$post_user['author_id']] = array(
                'cCount' => $post_user['cCount'],
                'rating' => $post_user['cCount'] * 10
            );

        $comment_users = $this->getTopCommentUsers($from_time);
        foreach ($comment_users as $comment_user)
            if (isset($result[$comment_user['author_id']])) {
                $result[$comment_user['author_id']]['rating'] += $comment_user['cmCount'];
                $result[$comment_user['author_id']]['cmCount'] = $comment_user['cmCount'];
            } else
                $result[$comment_user['author_id']] = array(
                    'cmCount' => $comment_user['cmCount'],
                    'rating' => $comment_user['cmCount']
                );

        //fill empty data
        foreach($result as $author_id => $user_data){
            if (!isset($user_data['cCount'])){
                $result[$author_id]['cCount'] = $this->getUserPostsCount($from_time, $author_id);
                $result[$author_id]['rating'] += $result[$author_id]['cCount']*10;
            }
            if (!isset($user_data['cmCount'])){
                $result[$author_id]['cmCount'] = $this->getUserCommentsCount($from_time, $author_id);
                $result[$author_id]['rating'] += $result[$author_id]['cmCount'];
            }
        }


        uasort($result, function ($a, $b) {
            return $b['rating'] - $a['rating'];
        });

        $result = array_slice($result, 0, 10, true);

        return $result;
    }

    /**
     * Top post authors with post count
     *
     * @param $from_time
     * @return array
     */
    public function getTopPostUsers($from_time)
    {
        $col = ($this->type == self::TYPE_CLUBS) ? 'r.community_id':'r.user_id';

        return Yii::app()->db->createCommand()
            ->select('author_id, count(c.id) as cCount')
            ->from('community__contents as c')
            ->join('community__rubrics as r', 'c.rubric_id = r.id AND '.$col.' IS NOT NULL')
            ->group('author_id')
            ->order('cCount desc')
            ->where('created > :from_time AND author_id != :happy_giraffe AND removed = 0',
            array(
                ':happy_giraffe' => User::HAPPY_GIRAFFE,
                ':from_time' => $from_time
            ))
            ->limit(self::LIMIT)
            ->queryAll();
    }

    /**
     * Top commentators with comments count
     *
     * @param $from_time
     * @return array
     */
    public function getTopCommentUsers($from_time)
    {
        return Yii::app()->db->createCommand()
            ->select('author_id, count(id) as cmCount')
            ->from('comments')
            ->group('author_id')
            ->order('cmCount desc')
            ->where('entity = :entity AND created > :from_time AND author_id != :happy_giraffe AND removed = 0',
            array(
                ':happy_giraffe' => User::HAPPY_GIRAFFE,
                ':entity' => ($this->type == self::TYPE_CLUBS) ? 'CommunityContent' : 'BlogContent',
                ':from_time' => $from_time
            ))
            ->limit(self::LIMIT)
            ->queryAll();
    }

    /**
     * Returns user posts count for current period
     *
     * @param string $from_time
     * @param int $user_id
     * @return int
     */
    public function getUserPostsCount($from_time, $user_id)
    {
        $col = ($this->type == self::TYPE_CLUBS) ? 'r.community_id':'r.user_id';

        return Yii::app()->db->createCommand()
            ->select('count(c.id)')
            ->from('community__contents as c')
            ->join('community__rubrics as r', 'c.rubric_id = r.id AND '.$col.' IS NOT NULL')
            ->where('created > :from_time AND author_id = :user_id AND removed = 0',
            array(
                ':user_id'=>$user_id,
                ':from_time' => $from_time
            ))
            ->queryScalar();
    }

    /**
     * Returns user comments count for current period
     *
     * @param string $from_time
     * @param int $user_id
     * @return int
     */
    public function getUserCommentsCount($from_time, $user_id)
    {
        return Yii::app()->db->createCommand()
            ->select('count(id)')
            ->from('comments')
            ->where('entity = :entity AND created > :from_time AND author_id = :user_id AND removed = 0',
            array(
                ':user_id'=>$user_id,
                ':entity' => ($this->type == self::TYPE_CLUBS) ? 'CommunityContent' : 'BlogContent',
                ':from_time' => $from_time
            ))
            ->queryScalar();
    }
}
