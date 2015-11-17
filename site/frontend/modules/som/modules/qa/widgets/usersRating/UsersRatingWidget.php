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

    public function run()
    {
        $models = array();
        foreach (QaUsersRatingManager::$periods as $type => $period) {
            $models[$type] = QaUserRating::model()->orderRating()->type($type)->findAll(array(
                'limit' => self::LIMIT,
            ));
        }

        $this->render('view', compact('models'));
    }
}