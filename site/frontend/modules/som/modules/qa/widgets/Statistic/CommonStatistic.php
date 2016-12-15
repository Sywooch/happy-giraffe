<?php

namespace site\frontend\modules\som\modules\qa\widgets\Statistic;

use site\frontend\modules\som\modules\qa\models\QaRating;
use site\frontend\modules\som\modules\qa\models\QaCategory;
/**
 * @author Emil Vililyaev
 */
class CommonStatistic extends \CWidget
{

    /**
     * {@inheritDoc}
     * @see CWidget::run()
     */
    public function run()
    {
        $rating = QaRating::model()->byCategory(QaCategory::PEDIATRICIAN_ID);
        $criteria = clone $rating->getDbCriteria();
        $criteria->select = 'SUM(votes_count) AS vc, SUM(answers_count) AS ac';

        $data = array_shift(\Yii::app()->db->getCommandBuilder()->createFindCommand($rating->tableName(), $criteria)->queryAll());

        $this->render('common_statistic', ['votes' => intval($data['vc']), 'answers' => intval($data['ac'])]);
    }

}