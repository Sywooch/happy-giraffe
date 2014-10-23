<?php
/**
 * @author Никита
 * @date 23/10/14
 */

namespace site\frontend\modules\family\models;


class PregnancyTwins extends Pregnancy
{
    public function getTitle()
    {
        return 'Ждем двойню';
    }
} 