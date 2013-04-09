<?php
/**
 * Author: alexk984
 * Date: 06.04.12
 */
class OurUsersWidget extends SimpleWidget
{
    public function run()
    {
        $criteria = new CDbCriteria(array(
            'select' => 't.id, t.gender, t.first_name, t.last_name, t.avatar_id,
                         count(community__contents.id) AS postsCount,
                         count(album__albums.id) AS albumsCount',
            'having' => 'postsCount > 1 AND albumsCount > 0',
            'group' => 't.id',
            'condition' => 't.birthday IS NOT NULL
                AND address.country_id IS NOT NULL
                AND t.avatar_id IS NOT NULL
                AND email_confirmed = 1',
            'join' => 'LEFT JOIN community__contents ON community__contents.author_id = t.id
                       LEFT JOIN album__albums ON album__albums.author_id = t.id AND type=0',
            'with'=>array(
                'avatar',
                'address',
            ),
            'limit'=>15,
            'order'=>'rand()',
        ));
        $users = User::model()->active()->findAll($criteria);

        $this->render('OurUsersWidget', compact('users'));
    }
}