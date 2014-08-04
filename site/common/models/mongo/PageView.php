<?php
/**
 * Class PageView
 *
 * Хранение количества просмотров страниц
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class PageView extends HMongoModel
{
    public function attributeNames()
    {
        return array();
    }

    /**
     * @var PageView
     */
    private static $_instance;
    protected $_collection_name = 'page_views';

    /**
     * @var int
     */
    public $views = 0;

    /**
     * @return PageView
     */
    public static function model()
    {
        if (null === self::$_instance)
            self::$_instance = new self();

        return self::$_instance;
    }

    private function __construct()
    {
    }

    /**
     * Найти запись по url
     *
     * @param string $path
     * @return array
     */
    public function findByPath($path)
    {
        return $this->getCollection()->findOne(array('_id' => $path));
    }

    /**
     * @param string $path
     * @return int
     */
    public function viewsByPath($path)
    {
        if (strpos($path, 'http://www.happy-giraffe.ru') === 0)
            $path = str_replace('http://www.happy-giraffe.ru', '', $path);
        //TODO DEBUG
        if (strpos($path, 'http://happy-giraffe.com') === 0)
            $path = str_replace('http://happy-giraffe.com', '', $path);

        if (($model = $this->findByPath($path)) !== null)
            return $model['views'];
        return 0;
    }

    /**
     * @param string $path
     * @return int
     */
    public function incViewsByPath($path)
    {
        if (($model = $this->findByPath($path)) === null) {
            $this->getCollection()->insert(array(
                '_id' => $path,
                'views' => 1,
            ));
            return 1;
        }

        return $this->inc($model);
    }

    /**
     * Увеличивает кол-во просмотров статьи на 1, проверяет что это не будет и
     * что он еще не посещал эту страницу. Данные о посещенных страницах хранит
     * в пользовательской сессии
     *
     * @param array $model
     * @return int кол-во просмотров статьи
     */
    public function inc($model)
    {
        if (isset($_SERVER['HTTP_USER_AGENT']) && !in_array($_SERVER['HTTP_USER_AGENT'], $this->getBots())) {
            $viewed_pages = Yii::app()->session->get('viewed_pages');
            if (strpos($viewed_pages, $this->_id . ',') === false) {
                $this->getCollection()->update(array('_id' => $model['_id']), array('$inc' => array('views' => 1)));

                $viewed_pages .= ' ' . $this->_id . ',';
                Yii::app()->session['viewed_pages'] = $viewed_pages;

                return $model['views'] + 1;
            }
        }

        return $model['views'];
    }

    public function cheat($path, $min, $max)
    {
        $model = $this->findByPath($path);
        if ($model === null) {
            $this->getCollection()->insert(array(
                '_id' => $path,
                'views' => mt_rand($min, $max),
            ));
        }
        else
            $this->getCollection()->update(array('_id' => $model['_id']), array('$inc' => array('views' => mt_rand($min, $max))));
    }

    /**
     * user-агенты ботов
     *
     * @return array
     */
    public static function getBots()
    {
        return array('googlebot', 'google', 'msnbot', 'ia_archiver', 'lycos', 'jeeves', 'scooter',
            'fast-webcrawler', 'slurp@inktomi', 'turnitinbot', 'technorati', 'yahoo', 'findexa',
            'findlinks', 'gaisbo', 'zyborg', 'surveybot', 'bloglines', 'blogsearch', 'pubsub',
            'syndic8', 'userland', 'gigabot', 'become.com',

            'teoma', 'scooter', 'yndex', 'stackrambler', 'mail.ru', 'aport', 'webalta', 'googlebot-mobile',
            'googlebot-image', 'mediapartners-google', 'adsbot-google', 'msnbot-newsblogs',
            'msnbot-products', 'msnbot-media'
        );
    }
}