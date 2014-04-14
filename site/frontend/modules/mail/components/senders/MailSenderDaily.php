<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 10/04/14
 * Time: 14:28
 * To change this template use File | Settings | File Templates.
 */

class MailSenderDaily extends MailSender
{



    public function sendAll()
    {
        $recipe = CookRecipe::model()->find();
        $photoPost = CommunityContent::model()->find('type = :type', array(':type' => CommunityContent::TYPE_PHOTO_POST));
        $posts = CommunityContent::model()->findAll(array('limit' => 4));
        $horoscopes = Horoscope::model()->findByAttributes(array(
            'data' => date("Y-m-d"),
        ));
    }

    public function process(User $user)
    {
        $horoscope = Horoscope::model()->findByAttributes(array(
            'zodiac' => Horoscope::model()->getDateZodiac($user->birthday),
            'date' => date("Y-m-d"),
        ));

        $newMessagesCount = MessagingManager::unreadMessagesCount($user->id);
        $newFriendsCount = FriendRequest::model()->getCountByUserId($user->id);


        return new MailMessageDaily($user, compact('horoscope'));
    }
}