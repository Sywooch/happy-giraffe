<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 08/08/14
 * Time: 14:10
 */

class AlphabetWidget extends CWidget
{
    public function run()
    {
        $letters = self::getRoutesLetters();
        $this->render('AlphabetWidget', compact('letters'));
    }

    public static function getRoutesLetters()
    {
        $sql = <<<SQL
SELECT DISTINCT LEFT(c.name, 1) AS letter
FROM `geo__city` c
INNER JOIN routes__routes r ON c.id = r.city_from_id
ORDER BY letter ASC;
SQL;
        return Yii::app()->db->cache(3600)->createCommand($sql)->queryColumn();
    }
} 