<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/7/12
 * Time: 1:41 PM
 * To change this template use File | Settings | File Templates.
 */
class FriendEventContest extends FriendEvent
{
    public $type = FriendEvent::TYPE_CONTEST_PARTICIPATED;
    public $work_id;

    private $_work;

    public function init()
    {
        $this->work = $this->_getWork();
    }

    public function getWork()
    {
        return $this->_work;
    }

    public function setWork($work)
    {
        $this->_work = $work;
    }

    private function _getWork()
    {
        return ContestWork::model()->findByPk($this->work_id, array(
            'with' => 'contest',
        ));
    }

    public function getLabel()
    {
        return 'Участвует в фотоконкурсе';
    }

    public function createBlock()
    {
        $this->work_id = (int) $this->params['id'];
        $this->user_id = (int) $this->params['user_id'];

        parent::createBlock();
    }

    public function getExist()
    {
        return $this->work !== null;
    }
}
