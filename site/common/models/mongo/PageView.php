<?php
class PageView extends EMongoDocument
{
    public $views = 0;

    public function getCollectionName()
    {
        return 'page_views';
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function findByPath($path)
    {
        return $this->findByPk($path);
    }

    public function viewsByPath($path)
    {
        if (strpos($path, 'http://www.happy-giraffe.ru') === 0)
            $path = str_replace('http://www.happy-giraffe.ru', '', $path);

        if (($model = $this->findByPath($path)) !== null)
            return $model->views;
        return 0;
    }

    public function incViewsByPath($path)
    {
        if (($model = $this->findByPath($path)) === null) {
            $model = new $this;
            $model->_id = $path;
            $model->save();
        }

        return $model->inc();
    }

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

    public function inc()
    {
        if (!in_array($_SERVER['HTTP_USER_AGENT'], $this->getBots())) {
            $viewed_pages = Yii::app()->session->get('viewed_pages');
            if (strpos($viewed_pages, $this->_id.',') === false) {
                $this->views++;
                $this->save();

                $viewed_pages .= ' '.$this->_id.',';
                Yii::app()->session['viewed_pages'] = $viewed_pages;
            }
        }

        return $this->views;
    }
}
