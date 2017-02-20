<?php

namespace site\frontend\modules\som\modules\qa\models\qaTag;

use site\frontend\modules\som\modules\qa\models\QaCategory;
use site\frontend\modules\som\modules\qa\models\QaTag;

/**
 * Class QaTagManager
 * @package site\frontend\modules\som\modules\qa\models\qaTag
 *
 * @author Sergey Gubarev
 */
class QaTagManager
{

    /**
     * Получить все теги
     *
     * @return array|mixed|null
     */
    public static function getAllTags()
    {
        return QaTag::model()
                    ->byCategory(QaCategory::PEDIATRICIAN_ID)
                    ->findAll()
                ;
    }

}