<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 11/28/12
 * Time: 12:16 PM
 * To change this template use File | Settings | File Templates.
 */
class EventManager
{
    public static function getLive()
    {
        $sql = '
            (SELECT id, last_updated, 0 AS type FROM community__contents WHERE last_updated IS NOT NULL)
            UNION
            (SELECT id, last_updated, 1 AS type FROM contest__contests WHERE last_updated IS NOT NULL)
            UNION
            (SELECT id, created AS last_updated, 2 AS type FROM cook__decorations ORDER BY id DESC LIMIT 1)
            UNION
            (SELECT id, last_updated, 3 AS type FROM cook__recipes WHERE last_updated IS NOT NULL)
            UNION
            (SELECT id, register_date AS last_updated, 4 AS type FROM users ORDER BY id DESC LIMIT 1)
            ORDER BY last_updated DESC
        ';

        return new CSqlDataProvider($sql, array(
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }
}
