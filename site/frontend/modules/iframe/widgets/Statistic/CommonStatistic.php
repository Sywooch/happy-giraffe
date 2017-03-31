<?php

namespace site\frontend\modules\iframe\widgets\Statistic;

use site\frontend\modules\iframe\models\QaRating;
use site\frontend\modules\iframe\models\QaCategory;
/**
 * @author Emil Vililyaev
 */
class CommonStatistic extends \CWidget
{

    public $my_statistic = false;

    /**
     * @var integer
     */
    public $userId;

    /**
     * {@inheritDoc}
     * @see CWidget::run()
     */
    public function run()
    {
        $rating = QaRating::model()->byCategory(QaCategory::PEDIATRICIAN_ID);

        if (!is_null($this->userId))
        {
            $rating->byUser($this->userId);
        }

        $criteria = clone $rating->getDbCriteria();
        $criteria->select = 'SUM(votes_count) AS vc, SUM(answers_count) AS ac';

        $list = \Yii::app()->db->getCommandBuilder()->createFindCommand($rating->tableName(), $criteria)->queryAll();
        $data = array_shift($list);

        $this->render('common_statistic', [
            'votes' => intval($data['vc']),
            'answers' => intval($data['ac']),
            'my_statistic' => $this->my_statistic,
        ]);
    }

}