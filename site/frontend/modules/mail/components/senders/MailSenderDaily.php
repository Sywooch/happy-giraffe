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
    protected $debugMode = self::DEBUG_DEVELOPMENT_WEB;

    protected $likes;
    protected $favourites;
    protected $recipe;
    protected $photoPost;
    protected $posts = array();
    protected $horoscopes;

    public function __construct()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.common.models.mongo.HGLike');
        Yii::import('site.common.models.mongo.Favourites');
        Yii::import('site.common.models.mongo.PageView');

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
        $this->setFavourites();

        if ($this->recipe === null) {
            throw new CException('Рецепт для ежедневной рассылки не выбран');
        }

        if ($this->photoPost === null) {
            throw new CException('Фотопост для ежедневной рассылки не выбран');
        }

        if (count($this->posts) < 4) {
            throw new CException('Количество обычных постов в ежедневной рассылке равно ' . count($this->posts));
        }

        NotificationCreate::generateLikes();
        NotificationCreate::generateFavourites();
        $this->horoscopes = Horoscope::model()->findAllByAttributes(array(
            'date' => date("2012-03-15"),
        ));

        parent::sendAll();
    }

    public function process(User $user)
    {
        $newMessagesCount = MessagingManager::unreadMessagesCount($user->id);
        $newFriendsCount = FriendRequest::model()->getCountByUserId($user->id);
        $newLikesCount = 0;
        $newFavouritesCount = 0;

        $newCommentsCount = 0;
        $notifications = Notification::model()->getNotificationsList($user->id, 0, 0, 999);
        foreach ($notifications as $notification) {
            if (in_array($notification->type, array(Notification::USER_CONTENT_COMMENT, Notification::REPLY_COMMENT))) {
                $newCommentsCount += $notification->getVisibleCount();
            }
            if ($notification->type == Notification::NEW_LIKE) {
                $newLikesCount += $notification->getVisibleCount();
            }
            if ($notification->type == Notification::NEW_FAVOURITE) {
                $newFavouritesCount += $notification->getVisibleCount();
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

    protected function setFavourites()
    {
        $favourites = Favourites::getListByDate(Favourites::BLOCK_MAIL, date("2014-04-17"));
        foreach ($favourites as $favourite) {
            $model = CActiveRecord::model($favourite->entity)->findByPk($favourite->entity_id);
            if ($model !== null) {
                switch ($favourite->entity) {
                    case 'CookRecipe':
                        $this->recipe = $model;
                        break;
                    case 'CommunityContent':
                    case 'BlogContent':
                        if ($model->type_id == CommunityContent::TYPE_PHOTO_POST) {
                            $this->photoPost = $model;
                        } elseif (count($this->posts) < 4) {
                            $this->posts[] = $model;
                        }
                        break;
                }
            }
        }
    }
}