<?php
/**
 * 5 самых-самых
 *
 * Самые активные авторы и комментаторы за всё время.
 *
 * Author: choo
 * Date: 13.05.2012
 */
class TopFiveWidget extends CWidget
{
    public function run()
    {
        $topAuthors = User::model()->findAll(array(
            'select' => 't.*, count(*) authorsRate',
            'join' => 'JOIN ' . CommunityContent::model()->tableName() . ' ON t.id = ' . CommunityContent::model()->tableName() . '.author_id',
            'group' => 't.id',
            'order' => 'authorsRate DESC',
            'limit' => '5',
            'condition' => 'DATE_SUB(CURDATE(), INTERVAL 3 DAY) <= ' . CommunityContent::model()->tableName() . '.created AND t.id != 1',
        ));

        $topCommentators = User::model()->findAll(array(
            'select' => 't.*, count(*) commentatorsRate',
            'join' => 'JOIN ' . Comment::model()->tableName() . ' ON t.id = ' . Comment::model()->tableName() . '.author_id',
            'group' => 't.id',
            'order' => 'commentatorsRate DESC',
            'limit' => '5',
            'condition' => 'DATE_SUB(CURDATE(), INTERVAL 3 DAY) <= ' . Comment::model()->tableName() . '.created AND t.id != 1',
        ));

        $this->render('TopFiveWidget', compact('topAuthors', 'topCommentators'));
    }
}

