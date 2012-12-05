<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 11/29/12
 * Time: 11:20 AM
 * To change this template use File | Settings | File Templates.
 */
class EventContest extends Event
{
    public $contest;
    public $works;

    public function setSpecificValues()
    {
        $this->contest = $this->getContest();
        $this->works = $this->getWorks();
    }

    public function getContest()
    {
        $criteria = new CDbCriteria(array(
            'with' => 'worksCount',
        ));

        return Contest::model()->findByPk($this->id, $criteria);
    }

    public function getWorks()
    {
        $criteria = new CDbCriteria(array(
            'with' => array(
                'photoAttach' => array(
                    'with' => 'photo',
                ),
            ),
            'limit' => 9,
            'order' => 't.created DESC',
            'condition' => 'contest_id = :contest_id',
            'params' => array(':contest_id' => $this->id),
        ));

        return ContestWork::model()->findAll($criteria);
    }
}
