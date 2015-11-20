<?php
/**
 * @author Никита
 * @date 17/11/15
 */

namespace site\frontend\modules\som\modules\qa\widgets\usersRating;


use site\frontend\modules\som\modules\qa\components\QaUsersRatingManager;
use site\frontend\modules\som\modules\qa\models\QaUserRating;

class UsersRatingWidget extends \CWidget
{
    const LIMIT = 5;
    const CACHE_DURATION = 300;

    public function run()
    {
        $models = array();

        \Yii::beginProfile('rateingSelect');
        foreach (\Yii::app()->controller->module->periods as $periodId => $periodData) {
            $models[$periodId] = QaUserRating::model()->cache(self::CACHE_DURATION)->orderRating()->type($periodId)->apiWith('user')->findAll(array(
                'limit' => self::LIMIT,
            ));
        }
        \Yii::endProfile('rateingSelect');

        $this->render('view', compact('models'));
    }
}