<?php
namespace site\frontend\modules\posts\modules\forums\widgets\onlineUsers;
use site\frontend\components\api\models\User;

/**
 * @author Никита
 * @date 29/10/15
 */

class OnlineUsersWidget extends \CWidget
{
    public $limit = 40;

    public function run()
    {
        $users = $this->getUsers();
        if (! empty($users)) {
            $this->render('view', compact('users'));
        }
    }

    /**
     * @todo обсудить
     */
    protected function getUsers()
    {
        $counters = \Yii::app()->comet->cmdOnlineWithCounters('onOff');
        $ids = array();
        $c = 0;
        foreach ($counters as $id => $counter) {
            if ($counter > 0 && $c <= $this->limit) {
                $userId = str_replace('onOff', '', $id);
                $ids[] = $userId;
            }
            $c++;
        }
        $models = User::model()->findAllByPk($ids, ['avatarSize' => 40]);
        return array_filter($models, function($model) {
            return $model->avatarUrl !== null;
        });
    }
}