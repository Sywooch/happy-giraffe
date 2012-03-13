<?php
/**
 * Author: choo
 * Date: 12.03.2012
 */
class UserFriendNotification extends EMongoDocument
{
    const FRIEND_INVITE = 0;
    const FRIEND_ACCEPT = 1;
    const FRIEND_DECLINE = 2;

    public static $_types = array(
        self::FRIEND_INVITE => 'ОГО! {user} предлагает подружиться',
        self::FRIEND_ACCEPT => 'УРА! {user} ответил согласием на вашу дружбу',
        self::FRIEND_DECLINE => 'ЖАЛЬ! {user} ответил отказом на вашу дружбу',
    );

    public $type;
    public $user_id;
    public $text;
    public $url;
    public $created;

    public function getCollectionName()
    {
        return 'friendNotifications';
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function createByRequest($type, $request)
    {
        $notification = new self;
        $notification->type = $type;
        if ($type == self::FRIEND_INVITE) {
            $recipient = $request->to;
            $sender = $request->from;
        } else {
            $recipient = $request->from;
            $sender = $request->to;
        }
        $notification->user_id = (int) $recipient->id;
        $notification->url = $sender->profileUrl;
        $notification->text = strtr(self::$_types[$type], array('{user}' => $sender->fullName));
        $notification->created = time();
        $notification->save();
    }

    public function getUserData($user_id)
    {
        return array(
            'count' => $this->getCount($user_id),
            'data' => $this->getLast($user_id),
        );
    }

    public function getLast($user_id)
    {
        $criteria = new EMongoCriteria;

        $criteria
            ->user_id('==', (int) $user_id)
            ->limit(5)
            ->sort('created', EMongoCriteria::SORT_DESC);

        $notifications = $this->findAll($criteria);

        $data = array();
        foreach ($notifications as $m) {
            $data[] = array(
                '_id' => $m->_id,
                'text' => $m->text,
                'url' => $m->url,
            );
        }

        return $data;
    }

    public function getCount($user_id)
    {
        return $this->countByAttributes(array('user_id' => (int) $user_id));
    }

    public function sendUpdate($user_id)
    {
        $comet = new CometModel;
        $comet->type = CometModel::TYPE_UPDATE_FRIEND_NOTIFICATIONS;
        $comet->send($user_id, $this->getUserData($user_id));
    }
}
