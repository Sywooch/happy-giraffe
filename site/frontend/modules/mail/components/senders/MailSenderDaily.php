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
    protected $debugMode = self::DEBUG_DEVELOPMENT_MAIL;

    protected $likes;
    protected $favourites;
    protected $recipe;
    protected $photoPost;
    protected $posts;
    protected $horoscopes;

    public function __construct()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.common.models.mongo.HGLike');

        Yii::import('site.frontend.modules.favourites.components.*');
        Yii::import('site.frontend.modules.favourites.models.*');

        Yii::import('site.frontend.modules.friends.components.*');
        Yii::import('site.frontend.modules.friends.models.*');

        Yii::import('site.frontend.modules.messaging.components.*');
        Yii::import('site.frontend.modules.messaging.models.*');

        Yii::import('site.frontend.modules.cook.components.*');
        Yii::import('site.frontend.modules.cook.models.*');

        Yii::import('site.frontend.modules.notifications.components.*');
        Yii::import('site.frontend.modules.notifications.models.base.*');
        Yii::import('site.frontend.modules.notifications.models.*');

        Yii::import('site.frontend.modules.services.modules.horoscope.models.*');
    }

    /**
     * @todo Заменить дату выборки гороскопов на актуальную
     * @return mixed|void
     */
    public function sendAll()
    {
        $this->likes = NotificationCreate::generateLikes();
        $this->favourites = NotificationCreate::generateFavourites();
        $this->recipe = CookRecipe::model()->find('photo_id IS NOT NULL');
        $this->photoPost = CommunityContent::model()->findByAttributes(array('type_id' => CommunityContent::TYPE_PHOTO_POST));
        $this->posts = CommunityContent::model()->findAll(array(
            'limit' => 4,
            'with' => 'post',
            'condition' => 'type_id = :type_id AND post.photo_id IS NOT NULL',
            'params' => array(':type_id' => CommunityContent::TYPE_POST),
        ));
        $this->horoscopes = Horoscope::model()->findAllByAttributes(array(
            'date' => date("2012-03-15"),
        ));

        $this->iterate();
    }

    public function process(User $user)
    {
        $newMessagesCount = MessagingManager::unreadMessagesCount($user->id);
        $newFriendsCount = FriendRequest::model()->getCountByUserId($user->id);
        $newLikesCount = isset($this->likes[$user->id]) ? $this->likes[$user->id] : 0;
        $newFavouritesCount = isset($this->favourites[$user->id]) ? $this->favourites[$user->id] : 0;

        $newCommentsCount = 0;
        $notifications = Notification::model()->getNotificationsList($user->id, 0, 0, 999);
        foreach ($notifications as $notification) {
            if (in_array($notification->type, array(Notification::USER_CONTENT_COMMENT, Notification::REPLY_COMMENT))) {
                $newCommentsCount += $notification->getVisibleCount();
            }
        }

        $horoscope = $this->horoscopes[Horoscope::model()->getDateZodiac($user->birthday)];

        return new MailMessageDaily($user, CMap::mergeArray(compact(
            'horoscope',
            'newMessagesCount',
            'newFriendsCount',
            'newLikesCount',
            'newFavouritesCount',
            'newCommentsCount'
        ), array(
            'recipe' => $this->recipe,
            'photoPost' => $this->photoPost,
            'posts' => $this->posts,
        )));
    }
}