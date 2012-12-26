<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 10/14/12
 * Time: 11:29 AM
 * To change this template use File | Settings | File Templates.
 */
class ContestWidget extends UserCoreWidget
{
    public $contest_id;
    public $registerGallery = true;

    public $_contest_work;
    public $_contest;

    public function init()
    {
        parent::init();

        $this->_contest = Contest::model()->cache(3600)->findByPk($this->contest_id);
        if ($this->_contest === null)
            return false;

        if ($this->_contest->status != Contest::STATUS_ACTIVE)
            $this->visible = false;
        else {
            $this->_contest_work = $this->user->getContestWork($this->contest_id);
            if (Yii::app()->user->isGuest){
                $this->visible = $this->_contest_work !== null;
            }else
                $this->visible = $this->isMyProfile && Yii::app()->user->getModel()->score->full || $this->_contest_work !== null;
        }
    }
}
