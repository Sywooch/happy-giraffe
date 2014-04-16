<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 10/04/14
 * Time: 14:26
 * To change this template use File | Settings | File Templates.
 */

class MailMessageDaily extends MailMessage
{
    public $type = 'daily';

    /**
     * Рецепт
     *
     * @property CookRecipe $recipe
     */
    public $recipe;

    /**
     * Гороскоп на сегодня
     *
     * @property Horoscope $horoscope
     */
    public $horoscope;

    /**
     * Фотопост
     *
     * @property CommunityContent $photoPost
     */
    public $photoPost;

    /**
     * Обычные посты
     *
     * @property CommunityContent[] $posts
     */
    public $posts = array();

    /**
     * Количество непрочитанных сообщений
     *
     * @property int $newMessagesCount
     */
    public $newMessagesCount;

    /**
     * Количество новых комментариев
     *
     * @property int $newCommentsCount
     */
    public $newCommentsCount;

    /**
     * Количество запросов дружбы
     *
     * @property int $newFriendsCount
     */
    public $newFriendsCount;

    /**
     * Количество лайков
     *
     * @property int $newLikesCount
     */
    public $newLikesCount;

    /**
     * Количество добавлений в избранное
     *
     * @property int $newFavouritesCount
     */
    public $newFavouritesCount;


    public function getSubject()
    {
        return 'Вас ждет много интересного на “Веселом Жирафе';
    }

    public function getMenuActiveElementsCount()
    {
        $counters = array(
            $this->newCommentsCount,
            $this->newCommentsCount,
            $this->newFriendsCount,
            $this->newLikesCount,
            $this->newFavouritesCount,
        );

        $c = 0;

        foreach ($counters as $counter) {
            if ($counter > 0) {
                $c++;
            }
        }

        return $c;
    }

    public function showMenu()
    {
        return $this->getMenuActiveElementsCount() > 0;
    }

    public function getTitle()
    {
        return 'Здравствуйте, ' . $this->user->first_name . '! В Вашем профиле появились новые события.';
    }

    public function getMessagesUrlParams()
    {
        if ($this->newMessagesCount > 0) {
            $contacts = ContactsManager::getContactsForDelivery($this->user->id, 1);
            $contact = $contacts[0];
            return array('/messaging/default/index', 'interlocutorId' => $contact->user->id);
        }
    }

    public function getFriendsUrlParams()
    {
        return array('/friends/default/index', 'tab' => 2);
    }

    public function getLikesUrlParams()
    {
        return array('/notifications/default/index');
    }

    public function getFavouritesUrlParams()
    {
        return array('/notifications/default/index');
    }

    public function getCommentsUrlParams()
    {
        return array('/notifications/default/index');
    }

    public function getPhotoPostImage(CommunityContent $photoPost)
    {
        //выберем фото и создадим объект Image на его основе
        $photo = $photoPost->gallery->items[0]->photo;
        $imageUrl = $photo->getPreviewPath(660, null, Image::WIDTH);
        $image = new Image($imageUrl, array('driver' => 'GD', 'params' => array()));

        //создадим объект Image на основе водного знака
        $watermarkUrl = Yii::getPathOfAlias('site.frontend.www-submodule.new.images.mail') . DIRECTORY_SEPARATOR . 'water-mark.png';
        $watermark = new Image($watermarkUrl, array('driver' => 'GD', 'params' => array()));

        //добавим водный знак
        $image->watermark($watermark, 80, ($image->width - 151) / 2, ($image->height - 151) / 2);

        //добавим текст
        $itemsCount = count($photoPost->gallery->items);
        $textWidth = 47 + strlen($itemsCount) * 10;
        $textX = ($image->width - $textWidth) / 2;
        $textY = ($image->height - 151) / 2 + 128;
        $textColor = array(51, 51, 51);
        $textFont = Yii::getPathOfAlias('site.frontend.www-submodule.font') . DIRECTORY_SEPARATOR . 'arial.ttf';
        $image->text(13.5, 0, $textX, $textY, $textColor, $textFont, $itemsCount . ' фото');

        //сохраним
        $image->save($photo->getMailPath());
        return $photo->getMailUrl();
    }
}