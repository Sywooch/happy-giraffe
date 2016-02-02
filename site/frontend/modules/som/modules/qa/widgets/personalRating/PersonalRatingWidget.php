<?php
/**
 * @author Никита
 * @date 02/12/15
 */

namespace site\frontend\modules\som\modules\qa\widgets\personalRating;

use site\frontend\modules\som\modules\qa\models\QaUserRating;

class PersonalRatingWidget extends \CWidget
{
    const PERIOD_ID = 'all';

    public $userId;

    public function run()
    {
        $model = QaUserRating::model()->user($this->userId)->type(self::PERIOD_ID)->find();
        if ($model !== null) {
            $this->render('view', compact('model'));
        }
    }
}