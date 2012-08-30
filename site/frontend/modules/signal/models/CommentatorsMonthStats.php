<?php

class CommentatorsMonthStats extends EMongoDocument
{
    const NEW_FRIENDS = 1;
    const BLOG_VISITS = 2;
    const PROFILE_UNIQUE_VIEWS = 3;
    const IM_MESSAGES = 4;
    const SE_VISITS = 5;

    public $period;
    public $commentators = array();

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'commentators_month_stats';
    }

    public function calculate()
    {
        $commentators = User::model()->findAll('`group`=' . UserGroup::COMMENTATOR);
        $this->commentators = array();

        foreach ($commentators as $commentator) {
            $model = $this->loadCommentator($commentator);
            if ($model !== null) {
                $result = array(
                    self::NEW_FRIENDS => (int)$model->newFriends($this->period),
                    self::BLOG_VISITS => (int)$model->blogVisits($this->period),
                    self::PROFILE_UNIQUE_VIEWS => (int)$model->profileUniqueViews($this->period),
                    self::IM_MESSAGES => (int)$model->imMessages($this->period),
                    self::SE_VISITS => (int)$model->seVisits($this->period),
                );
                $this->commentators[(int)$commentator->id] = $result;
            }
        }
    }

    /**
     * @param $commentator
     * @return CommentatorWork
     */
    public function loadCommentator($commentator)
    {
        $criteria = new EMongoCriteria;
        $criteria->user_id('==', (int)$commentator->id);
        return CommentatorWork::model()->find($criteria);
    }

    public function getPlace($user_id, $counter)
    {
        $arr = array();
        foreach ($this->commentators as $_user_id => $data)
            $arr[$_user_id] = $data[$counter];

        asort($arr);
        $i = 1;
        foreach ($arr as $_user_id => $data) {
            if ($_user_id == $user_id || $data == $arr[$user_id])
                return $i;
            $i++;
        }

        return null;
    }
}
