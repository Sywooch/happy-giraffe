<?php
/**
 * Author: choo
 * Date: 14.05.2012
 */
class SiteCommand extends CConsoleCommand
{
    private $recipients = array(
        'choojoy.work@gmail.com',
        'alexk984@gmail.com',
        'lnghost@hotmail.com',
    );

    public function actionCheckSeo()
    {
        //robots
        $url = 'http://www.happy-giraffe.ru/robots.txt';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $robotsResult = $httpStatus == 200;

        //sitemap
        $url = 'http://www.happy-giraffe.ru/sitemap.xml';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $sitemapResult = simplexml_load_string($response) !== FALSE;

        $output =
            'robots.txt - ' . ($robotsResult ? 'OK' : 'BROKEN') . "\n" .
                'sitemap.xml - ' . ($sitemapResult ? 'OK' : 'BROKEN') . "\n";

        if (!($robotsResult && $sitemapResult)) {
            mail(implode(', ', $this->recipients), 'happy-giraffe.ru seo check failure', $output);
        }
    }

    public $moderators = array(23, 83, 10023, 10264, 10064);
    public $smo = array(12998, 13093, 13130, 13094, 13217);
    public $editors = array(10379, 10378, 10265, 12949, 10385, 10384, 13361, 13107, 12950, 13096,
        13235, 13122, 10433, 13002, 13105, 13099, 12411, 13101, 13103, 13098, 10358, 13136, 10359, 13137, 10391);

    /**
     * mark all users with role
     */
    /*public function actionUserGroups()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->moderators);

        $users = User::model()->findAll($criteria);
        foreach ($users as $user) {
            $user->group = UserGroup::MODERATOR;
            $user->update(array('group'));
        }

        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->smo);

        $users = User::model()->findAll($criteria);
        foreach ($users as $user) {
            $user->group = UserGroup::SMO;
            $user->update(array('group'));
        }

        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->editors);

        $users = User::model()->findAll($criteria);
        foreach ($users as $user) {
            $user->group = UserGroup::EDITOR;
            $user->update(array('group'));
        }

        //virtuals
        $users = Yii::app()->db->createCommand('select distinct(userid) from auth__assignments where itemname="virtual_user"')->queryColumn();
        foreach ($users as $user_id) {
            $user = User::getUserById($user_id);
            $user->group = UserGroup::VIRTUAL;
            $user->update(array('group'));
        }
    }*/

    public function actionFormatDiseases()
    {
        Yii::import('site.frontend.modules.services.modules.recipeBook.models.*');
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');
        Yii::import('site.frontend.helpers.*');

        $dizz = RecipeBookDisease::model()->findAll();
        foreach ($dizz as $diz) {

            $doc = phpQuery::newDocumentXHTML($diz->text, $charset = 'utf-8');
            //чистим атрибуты
            foreach (pq('h2, h3, p, strong, b, em, u, s, li') as $e) {
                pq($e)->removeAttr('style');
            }

            //убираем фонты
            foreach (pq('font') as $s) {
                pq($s)->replaceWith(pq($s)->html());
            }

            //убираем спаны
            while (count(pq('span')) > 0) {
                foreach (pq('span') as $s) {
                    pq($s)->replaceWith(pq($s)->html());
                }
            }

            //убираем em
            while (count(pq('em')) > 0) {
                foreach (pq('em') as $s) {
                    pq($s)->replaceWith(pq($s)->html());
                }
            }

            $diz->text = $doc;

            $image = $diz->getImage();
            if ($image !== false && !empty($image)) {
                $path = Yii::getPathOfAlias('site.frontend.www') . $image;
                if (file_exists($path)) {

                    $info = pathinfo($image);
                    $file_name = $info['basename'];
                    echo $file_name;

                    $dir = Yii::getPathOfAlias('site.common.uploads.photos.originals.') . DIRECTORY_SEPARATOR . '1';
                    if (!file_exists($dir))
                        mkdir($dir);

                    $new_path = $dir . DIRECTORY_SEPARATOR . $file_name;
                    if (!file_exists($new_path))
                        copy($path, $new_path);

                    $photo = new AlbumPhoto();
                    $photo->title = $diz->title;
                    $photo->author_id = 1;
                    $photo->file_name = $file_name;
                    $photo->fs_name = $file_name;
                    $photo->save();

                    $diz->photo_id = $photo->id;
                }
                //убираем фонты
                foreach (pq('img') as $s) {
                    pq($s)->replaceWith('');
                }
            }
            $diz->save();
        }
    }

    public function actionSendCard($photo_id)
    {
        $users = Yii::app()->db->createCommand()
            ->select('id')
            ->from('users')
            ->where('deleted = 0 AND blocked = 0')
            ->queryAll();

        foreach ($users as $u) {
            $comment = new Comment('giraffe');
            $comment->author_id = 1;
            $comment->entity = 'User';
            $comment->entity_id = $u['id'];
            $comment->save();

            $attach = new AttachPhoto;
            $attach->photo_id = $photo_id;
            $attach->entity = 'Comment';
            $attach->entity_id = $comment->id;
            $attach->save();
        }
    }

    public function actionGeneratePreviews()
    {
        Yii::import('site.frontend.extensions.image.Image');
        Yii::import('site.frontend.extensions.helpers.CArray');

        $limit = 1000;
        $offset = 0;
        $i = 0;

        while ($photos = AlbumPhoto::model()->active()->findAll(array('order' => 'id DESC', 'limit' => $limit, 'offset' => $offset))) {
            foreach ($photos as $p) {
                echo ++$i . ':' . $p->getPreviewUrl(960, 627, Image::HEIGHT) . "\n";
            }
            $offset += $limit;
        }
    }

    public function actionRemoveOldNotifications()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.extensions.*');
        Yii::import('site.frontend.components.*');
        Yii::import('site.frontend.helpers.*');
        Yii::import('site.common.models.mongo.*');

        $criteria = new EMongoCriteria();
        $criteria->created('<', strtotime('-1 month'));
        UserNotification::model()->deleteAll($criteria);
    }

    public function actionFix2()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.modules.cook.models.*');
        Yii::import('site.common.models.mongo.*');

        $users = Yii::app()->db->createCommand()->select('id')->from('users')->where('`group` = 6')->queryColumn();
        foreach ($users as $user) {
            $criteria = new EMongoCriteria();
            $criteria->type = UserAction::USER_ACTION_COMMENT_ADDED;
            $criteria->user_id = (int)$user;

            $actions = UserAction::model()->findAll($criteria);
            echo count($actions) . "\n";
            foreach ($actions as $action) {
                $comment = Comment::model()->findByPk($action->data['id']);
                if ($comment !== null) {
                    $model = CActiveRecord::model($comment->entity)->findByPk($comment->entity_id);
                    if (empty($model->rubric_id)) {
                        $action->delete();
                        echo "+\n";
                    }
                }
            }
        }
    }

    public function actionBelCities(){
        $cities = 'Барановичи
Барань
Белоозёрск
Берёза
Березино
Берёзовка
Бобруйск
Борисов
Браслав
Брест
Буда-Кошелёво
Быхов
Василевичи
Верхнедвинск
Ветка
Вилейка
Витебск
Волковыск
Воложин
Высокое
Ганцевичи
Глубокое
Гомель
Горки
Городок
Гродно
Давид-Городок
Дзержинск
Дисна
Добруш
Докшицы
Дрогичин
Дубровно
Дятлово
Ельск
Жабинка
Житковичи
Жлобин
Жодино
Заславль
Иваново
Ивацевичи
Ивье
Калинковичи
Каменец
Кировск
Клецк
Климовичи
Кличев
Кобрин
Копыль
Коссово
Костюковичи
Кричев
Крупки
Лепель
Лида
Логойск
Лунинец
Любань
Ляховичи
Малорита
Марьина Горка
Микашевичи
Минск
Миоры
Могилёв
Мозырь
Молодечно
Мосты
Мстиславль
Мядель
Наровля
Несвиж
Новогрудок
Новолукомль
Новополоцк
Орша
Осиповичи
Ошмяны
Петриков
Пинск
Полоцк
Поставы
Пружаны
Речица
Рогачёв
Светлогорск
Свислочь
Сенно
Скидель
Славгород
Слоним
Слуцк
Смолевичи
Сморгонь
Солигорск
Старые Дороги
Столбцы
Столин
Толочин
Туров
Узда
Фаниполь
Хойники
Чаусы
Чашники
Червень
Чериков
Чечерск
Шклов
Щучин';
        $cities = explode("\n", $cities);

        Yii::import('site.frontend.modules.geo.models.*');
        foreach ($cities as $city) {
            $city = trim($city);
            $model = GeoCity::model()->find('country_id=20 AND name="' . $city . '"');
            if ($model !== null) {
                $model->type = 'г';
                $model->update(array('type'));
            }
        }

        $model = new GeoCity;
        $model->country_id = 20;
        $model->region_id = 38;
        $model->name = 'Брест';
        $model->type = 'г';
        $model->save();

        $model = new GeoCity;
        $model->country_id = 20;
        $model->region_id = 39;
        $model->name = 'Витебск';
        $model->type = 'г';
        $model->save();

        $region = new GeoRegion;
        $region->country_id = 20;
        $region->name = 'Минск';
        $region->type = 'г';
        $region->position = 2;
        $region->save();

        $model = new GeoCity;
        $model->country_id = 20;
        $model->region_id = $region->id;
        $model->name = 'Минск';
        $model->type = 'г';
        $model->save();
        $region->center_id = $model->id;

        $model = new GeoCity;
        $model->country_id = 20;
        $model->region_id = 43;
        $model->name = 'Могилёв';
        $model->type = 'г';
        $model->save();
    }
}