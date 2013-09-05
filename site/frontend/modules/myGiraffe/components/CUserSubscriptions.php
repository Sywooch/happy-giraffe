<?php
/**
 * insert Description
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */

class CUserSubscriptions
{
    /**
     * @var CUserSubscriptions
     */
    private static $_instance;
    /**
     * @var int
     */
    private $user_id;
    private $club_ids = null;

    /**
     * @param int $user_id
     * @return CUserSubscriptions
     */
    public static function getInstance($user_id)
    {
        if (null === self::$_instance) {
            self::$_instance = new self($user_id);
        }

        return self::$_instance;
    }

    private function __construct($user_id)
    {
    }

    /**
     * Возвращает список id клубов, на которые подписан
     * @return int[]
     */
    public function getSubUserClubIds()
    {
        if ($this->club_ids === null)
            $this->club_ids = Yii::app()->db->createCommand()
                ->select('club_id')
                ->from(UserClubSubscription::model()->tableName())
                ->where('user_id=:user_id', array(':user_id' => $this->user_id))
                ->queryColumn();
        return $this->club_ids;
    }

    /**
     * Подписан ли user на клуб
     *
     * @param int $club_id
     * @return bool успех
     */
    public function subscribed($club_id)
    {
        return in_array($club_id, $this->getSubUserClubIds());
    }

    /**
     * сообщества, на которые не подписан
     * @return int[]
     */
    public function getNotSubscribedClubIds()
    {
        $all_club_ids = Yii::app()->db->cache(3600)->createCommand()
            ->select('id')
            ->from('community__clubs')
            ->where('id NOT IN (19,21,22)')#TODO убрать потом
            ->queryColumn();

        $result = array();
        foreach($all_club_ids as $id)
            if (!in_array($id, $this->getSubUserClubIds()))
                $result [] = $id;
        return $result;
    }
} 