<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 10/04/14
 * Time: 14:28
 * To change this template use File | Settings | File Templates.
 */

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

class MailSenderDaily extends MailSender
{
    public $type = 'daily';
    protected $debugMode = self::DEBUG_TESTING;

    /**
     * @property $date
     */
    protected $date;

    /**
     * @property CookRecipe $recipe
     */
    protected $recipe;

    /**
     * @property CommunityContent $photoPost
     */
    protected $photoPost;

    /**
     * Обычные посты на сегодня
     *
     * @property CommunityContent[] $posts
     */
    protected $posts = array();

    /**
     * Массив гороскоп каждого знака зодиака на сегодняшний день
     *
     * @property Horoscope[] $horoscopes
     */
    protected $horoscopes;

    /**
     * Массив гороскоп каждого знака зодиака на завтра
     *
     * @property Horoscope[] $horoscopes
     */
    protected $tomorrowHoroscopes;

    public function __construct($date = null)
    {
        $this->date = ($date === null) ? self::nextDate() : $date;
    }

    public static function nextDate()
    {
        if (in_array(date("w"), array(6, 0, 1))) {
            return date("Y-m-d", strtotime('next tuesday'));
        }
        else {
            return date("Y-m-d", strtotime('+1 day'));
        }
    }

    protected function beforeSend()
    {
        $this->setFavourites();

        if ($this->recipe === null) {
            throw new CException('Рецепт для ежедневной рассылки не выбран');
        }

        if ($this->recipe->getMainPhoto() === null) {
            throw new CException('Рецепт без картинки');
        }

        if ($this->photoPost === null) {
            throw new CException('Фотопост для ежедневной рассылки не выбран');
        }

        if (count($this->posts) != 4) {
            throw new CException('Количество обычных постов в ежедневной рассылке равно ' . count($this->posts));
        }

        foreach ($this->posts as $post) {
            if ($post->getPhoto() === null) {
                throw new CException('Нет картинки у поста ' . $post->getUrl(false, true));
            }
            if ($post->getUnknownClassCommentsCount() == 0) {
                throw new CException('Нет комментариев у поста ' . $post->getUrl(false, true));
            }
        }

        $this->horoscopes = Horoscope::model()->findAllByAttributes(array(
            'date' => $this->date,
        ), array(
            'index' => 'zodiac',
        ));

        $this->tomorrowHoroscopes = Horoscope::model()->findAllByAttributes(array(
            'date' => date("Y-m-d", strtotime($this->date . ' + 1 day')),
        ), array(
            'index' => 'zodiac',
        ));

        echo '0';

        if (count($this->horoscopes) != 12) {
            throw new CHttpException('Гороскоп на сегодня заполнен не для всех знаков зодиака');
        }

        if (count($this->tomorrowHoroscopes) != 12) {
            throw new CException('Гороскоп на завтра заполнен не для всех знаков зодиака');
        }

        echo '1';

        NotificationCreate::generateLikes();
        NotificationCreate::generateFavourites();

        echo '2';

        die;

        return true;
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

        $zodiac = Horoscope::model()->getDateZodiac($user->birthday);
        $horoscope = $this->horoscopes[$zodiac];
        $tomorrowHoroscope = $this->tomorrowHoroscopes[$zodiac];

        $message = new MailMessageDaily($user, CMap::mergeArray(compact(
            'horoscope',
            'tomorrowHoroscope',
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

        Yii::app()->postman->send($message);
    }

    protected function setFavourites()
    {
        $favourites = Favourites::getListByDate(Favourites::BLOCK_MAIL, $this->date);

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