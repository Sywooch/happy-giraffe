<?php

namespace site\frontend\modules\som\modules\qa\widgets\usersTop;

use site\frontend\components\TopWidgetAbstract;
use site\frontend\modules\som\modules\qa\models\QaRating;
use site\frontend\modules\som\modules\qa\models\QaCategory;
use site\frontend\components\api\models\User;

/**
 * @author Emil Vililyaev
 */
class NewUsersTopWidget extends UsersTopWidget
{

    /**
     * @var integer
     */
    const nameLengthLimit = 17;

    /**
     * @var boolean
     * in list only users or ONLY specialists, all users need implement
     */
    public $onlyUsers = TRUE;

    /**
     * @param string $name
     * @return string
     */
    public function formattedName($name)
    {
        if (!is_string($name) || mb_strlen($name, 'UTF-8') < self::nameLengthLimit)
        {
            return $name;
        }

        return mb_substr($name, 0, self::nameLengthLimit - 1, 'UTF-8') . '&#8230';
    }

    /**
     * {@inheritDoc}
     * @see \site\frontend\modules\som\modules\qa\widgets\usersTop\UsersTopWidget::init()
     */
    public function init()
    {
        $this->setViewName($this->viewFileName);
        $this->_setTitle();
    }

    /**
     * {@inheritDoc}
     * @see \site\frontend\components\TopWidgetAbstract::getData()
     */
    public function getData()
    {
        $this->_process($this->onlyUsers);

        $top = array_slice($this->scores, 0, $this->getLimit(), true);

        $users = User::model()->findAllByPk(array_keys($top), ['avatarSize' => 40]);

        $rows = [];
        foreach ($top as $uId => $score)
        {
            $rows[] = [
                'user' => $users[$uId],
                'score' => $score->total_count,
                'votes' => $score->votes_count,
                'answers' => $score->answers_count,
            ];
        }


        if (empty($rows))
        {
            return; //@todo Emil Vililyaev: для того чтобы не проверять if (!empty($data['rows'])... нужно отрефакторить все зависимые view
        }

        return ['rows' => $rows];
    }

    //-----------------------------------------------------------------------------------------------------------

    /**
     * {@inheritDoc}
     * @see \site\frontend\components\TopWidgetAbstract::_process()
     */
    protected function _process($onlyUsers = TRUE)
    {
        $rating = QaRating::model()->byCategory(QaCategory::PEDIATRICIAN_ID);

        if ($onlyUsers)
        {
             $rating->notSpecialist();
        } else {
            $rating->forSpecialists();
        }

        $arrRating = $rating->findAll(['order' => 'total_count DESC', 'limit' => $this->getLimit()]);

        foreach ($arrRating as $rating)
        {
            $this->scores[$rating->user_id] = $rating;
        }
    }

}