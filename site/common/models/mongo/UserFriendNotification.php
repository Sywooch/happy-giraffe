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
        self::FRIEND_INVITE => '<span class="red">ОГО!</span>&nbsp;&nbsp;{user} предлагает подружиться',
        self::FRIEND_ACCEPT => '<span class="yellow">УРА!</span>&nbsp;&nbsp;{user} ответил согласием на вашу дружбу',
        self::FRIEND_DECLINE => '<span class="green">ЖАЛЬ!</span>&nbsp;&nbsp;{user} ответил отказом на вашу дружбу',
    );

    public $type;
    public $user_id;
    public $request_id;
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

    protected function afterSave()
    {
        parent::afterSave();

        $this->sendUpdate($this->user_id);
    }

    protected function afterDelete()
    {
        parent::afterDelete();

        $this->sendUpdate($this->user_id);
    }

    public function createByRequest($request)
    {
        $notification = new self;
        switch ($request->status) {
            case 'pending':
                $type = self::FRIEND_INVITE;
                break;
            case 'accepted':
                $type = self::FRIEND_ACCEPT;
                break;
            case 'declined':
                $type = self::FRIEND_DECLINE;
                break;
        }
        $notification->type = $type;
        if ($type == self::FRIEND_INVITE) {
            $recipient = $request->to;
            $sender = $request->from;
        } else {
            $recipient = $request->from;
            $sender = $request->to;
        }
        $notification->user_id = (int) $recipient->id;
        $notification->request_id = (int) $request->id;
        $notification->url = $sender->url;
        $notification->text = strtr(self::$_types[$type], array('{user}' => CHtml::tag('span', array('class' => 'name'), $sender->fullName)));
        $notification->created = time();
        $notification->save();
    }

    public function getUserData($user_id)
    {
        return array(
            'count' => $this->getCount($user_id),
            'data' => $this->getLast($user_id),
            'invite' => $this->type == self::FRIEND_INVITE,
        );
    }

    public function deleteInvitation($request_id)
    {
        $model = $this->findByAttributes(array(
            'type' => self::FRIEND_INVITE,
            'request_id' => (int) $request_id,
        ));
        return $model !== null ? $model->delete() : false;
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
                '_id' => (string) $m->_id,
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
