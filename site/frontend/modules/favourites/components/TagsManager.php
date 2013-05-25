<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 5/16/13
 * Time: 5:45 PM
 * To change this template use File | Settings | File Templates.
 */
class TagsManager
{
    public static function getFirstLetters($userId)
    {
        $sql = "
            SELECT DISTINCT LOWER(LEFT(t.name, 1))
            FROM favourites f
            INNER JOIN favourites__tags_favourites tf ON tf.favourite_id = f.id
            INNER JOIN favourites__tags t ON t.id = tf.tag_id
            WHERE f.user_id = :user_id
            ORDER BY t.name ASC;
        ";
        return Yii::app()->db->createCommand($sql)->queryColumn(array(':user_id' => $userId));
    }

    public static function getTagsByFirstLetter($userId, $firstLetter)
    {
        $sql = "
            SELECT t.id, t.name, COUNT(*) c
            FROM favourites f
            INNER JOIN favourites__tags_favourites tf ON tf.favourite_id = f.id
            INNER JOIN favourites__tags t ON t.id = tf.tag_id
            WHERE f.user_id = :user_id AND LOWER(LEFT(t.name, 1)) = :first_letter
            GROUP BY t.id
            ORDER BY t.name ASC;
        ";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(':user_id', $userId);
        $command->bindValue(':first_letter', $firstLetter);
        return $command->queryAll();
    }

    public static function getPopularTags($userId, $limit)
    {
        $sql = "
            SELECT x.id, x.name, x.c FROM
            (
                SELECT t.id, t.name, COUNT(*) c
                FROM favourites f
                INNER JOIN favourites__tags_favourites tf ON tf.favourite_id = f.id
                INNER JOIN favourites__tags t ON t.id = tf.tag_id
                WHERE f.user_id = :user_id
                GROUP BY t.id
                ORDER BY c DESC
                LIMIT :limit
            ) x
            ORDER BY x.name ASC;
        ";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(':user_id', $userId);
        $command->bindValue(':limit', $limit);
        return $command->queryAll();
    }

    public static function searchTag($userId, $tagName)
    {
        $sql = "
            SELECT t.id, t.name, COUNT(*) c
            FROM favourites__tags t
            INNER JOIN favourites__tags_favourites tf ON tf.tag_id = t.id
            INNER JOIN favourites f ON f.id = tf.favourite_id
            WHERE f.user_id = :user_id AND t.name = :tag_name
            GROUP BY t.id;
        ";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(':user_id', $userId);
        $command->bindValue(':tag_name', $tagName);
        return $command->queryRow();
    }

    public static function processForCloud($tags)
    {
        $result = array();
        foreach ($tags as $tag) {
            $result[$tag['name']] = array(
                'weight' => $tag['c'],
                'url' => Yii::app()->createUrl('/favourites/default/index', array('tagId' => $tag['id'])),
            );
        }
        return $result;
    }
}
