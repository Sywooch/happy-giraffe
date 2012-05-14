<?php
/**
 * Author: choo
 * Date: 13.05.2012
 */
class TopFive extends CWidget
{
    public function run()
    {
        $topAuthors = User::model()->findAll(array(
            'select' => 't.*, count(*) authorsRate',
            'join' => 'JOIN ' . CommunityContent::model()->tableName() . ' ON t.id = ' . CommunityContent::model()->tableName() . '.author_id',
            'group' => 't.id',
            'order' => 'authorsRate DESC',
            'limit' => '5',
        ));

        $topCommentators = User::model()->findAll(array(
            'select' => 't.*, count(*) commentatorsRate',
            'join' => 'JOIN ' . Comment::model()->tableName() . ' ON t.id = ' . Comment::model()->tableName() . '.author_id',
            'group' => 't.id',
            'order' => 'commentatorsRate DESC',
            'limit' => '5',
            'condition' => 't.id != 1',
        ));

        $this->render('TopFive', compact('topAuthors', 'topCommentators'));
    }
}

