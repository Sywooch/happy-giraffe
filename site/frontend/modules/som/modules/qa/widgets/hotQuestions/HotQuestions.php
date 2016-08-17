<?php

namespace site\frontend\modules\som\modules\qa\widgets\hotQuestions;

use site\frontend\modules\som\modules\qa\models\QaQuestion;
/**
 * @author Emil Vililyaev
 */
class HotQuestions extends \CWidget
{

    /**
     * @var integer
     */
    public $questionsLimit = 1;

    //-----------------------------------------------------------------------------------------------------------

    /**
     * {@inheritDoc}
     * @see CWidget::run()
     */
    public function run()
    {
        $this->render('view', ['data' => $this->_getData()]);
    }

    /**
     * @return \site\frontend\modules\som\modules\qa\models\QaQuestion[]
     */
    private function _getData()
    {
        $model = clone QaQuestion::model();
        /* @var $criteria \CDbCriteria */
        $model->apiWith('user')->with('category');
        $model->orderRating();
        $model->getDbCriteria()->limit = $this->questionsLimit;

        return $model->findAll();
    }

}