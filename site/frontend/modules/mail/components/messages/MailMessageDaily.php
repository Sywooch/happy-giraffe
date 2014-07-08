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
     * Гороскоп на завтра
     *
     * @property Horoscope $tomorrowHoroscope
     */
    public $tomorrowHoroscope;

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
        if ($this->getMenuActiveElementsCount() == 1 || $this->getMenuActiveElementsCount() == 2) {
            $a = array();
            if ($this->newCommentsCount > 0) {
                $a[] = $this->newCommentsCount . ' ' . Str::GenerateNoun(array('новый комментарий', 'новых комментария', 'новых комментариев'), $this->newCommentsCount);
            }

            if ($this->newMessagesCount > 0) {
                $a[] .= $this->newCommentsCount . ' ' . Str::GenerateNoun(array('новое сообщение', 'новых сообщения', 'новых сообщений'), $this->newMessagesCount);
            }

            if ($this->newFriendsCount > 0) {
                $a[] .= $this->newCommentsCount . ' ' . Str::GenerateNoun(array('приглашение дружить', 'приглашения дружить', 'приглашений дружить'), $this->newFriendsCount);
            }

            if ($this->newLikesCount > 0) {
                $a[] .= $this->newCommentsCount . ' ' . Str::GenerateNoun(array('новый лайк', 'новых лайка', 'новых лайков'), $this->newLikesCount);
            }

            if ($this->newFavouritesCount > 0) {
                $a[] .= $this->newCommentsCount . ' ' . Str::GenerateNoun(array('добавление в избранное', 'добавления в избранное', 'добавлений в избранное'), $this->newFavouritesCount);
            }

            return 'У Вас ' . implode(', ', $a) . ' и еще много-много интересного.';
        } else {
            return 'Вас ждет много интересного на “Веселом Жирафе”';
        }
    }

    public function getMenuActiveElementsCount()
    {
        $counters = array(
            $this->newCommentsCount,
            $this->newMessagesCount,
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
        if ($this->getMenuActiveElementsCount() > 0) {
            return 'Здравствуйте, ' . $this->user->first_name . '! В Вашем профиле появились новые события.';
        } else {
            return 'У Вас не было новых событий, но мы предлагаем новости нашего сайта.';
        }
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
        //выберем фото и сделаем копию
        $originalPhoto = $photoPost->gallery->items[0]->photo;


        $photo = clone $originalPhoto;

        //создадим объект Image на основе склонированного изображения
        $imagePath = $photo->getPreviewPath(660, null, Image::WIDTH, false, AlbumPhoto::CROP_SIDE_CENTER, true);
        $image = new Image($imagePath, array('driver' => 'GD', 'params' => array()));

        $this->watermark($image, 'water-mark.png', 80);

        //добавим текст
        $itemsCount = count($photoPost->gallery->items);
        $textWidth = 47 + strlen($itemsCount) * 10;
        $textX = ($image->width - $textWidth) / 2;
        $textY = ($image->height - 151) / 2 + 128;
        $textColor = array(51, 51, 51);
        $textFont = Yii::getPathOfAlias('site.frontend.www-submodule.font') . DIRECTORY_SEPARATOR . 'arial.ttf';
        $image->text(13.5, 0, $textX, $textY, $textColor, $textFont, $itemsCount . ' фото');

        //сохраним
        $image->save($imagePath);
        return $photo->getPreviewUrl(660, null, Image::WIDTH);
    }

    public function getPostImage(CommunityContent $post)
    {
        $originalPhoto = $post->getPhoto();
        if ($originalPhoto) {
            if ($post->type_id == CommunityContent::TYPE_VIDEO) {
                //скопируем фото
                $photo = clone $originalPhoto;

                //создадим объект Image на основе склонированного изображения
                $imagePath = $photo->getPreviewPath(318, null, Image::WIDTH);
                $image = Image::factory($imagePath, array('driver' => 'GD', 'params' => array()));

                $this->watermark($image, 'water-mark-youtube.png');

                //сохраним
                $image->save($imagePath);
                return $photo->getPreviewUrl(318, null, Image::WIDTH);
            } else {
                return $originalPhoto->getPreviewUrl(318, null, Image::WIDTH);
            }
        }
        return null;
    }

    protected function watermark($image, $watermarkFile, $opacity = 100)
    {
        $watermarkPath = Yii::getPathOfAlias('site.frontend.www-submodule.new.images.mail') . DIRECTORY_SEPARATOR . $watermarkFile;
        $watermark = Image::factory($watermarkPath, array('driver' => 'GD', 'params' => array()));

        $image->watermark($watermark, $opacity, ($image->width - $watermark->width) / 2, ($image->height - $watermark->height) / 2);

        return $image;
    }
}