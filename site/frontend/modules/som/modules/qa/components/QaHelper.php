<?php
/**
 * @author Никита
 * @date 18/11/15
 */

namespace site\frontend\modules\som\modules\qa\components;


class QaHelper
{
    public static function getRatingClass($index)
    {
        switch ($index) {
            case 0:
                return 'yellow-crown';
            case 1:
                return 'blue-crown';
            case 2:
                return 'orange-crown';
        }
        return 'nocrown';
    }
}