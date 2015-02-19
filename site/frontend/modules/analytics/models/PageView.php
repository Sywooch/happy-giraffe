<?php
/**
 * @author Никита
 * @date 26/01/15
 */

namespace site\frontend\modules\analytics\models;


use site\frontend\modules\posts\models\Content;

class PageView extends \EMongoDocument
{
    public $visits = 0;
    public $correction = 0;
    public $created;
    public $updated;
    public $synced;

    public function getCollectionName()
    {
        return 'views';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return array(
            array('visits, correction', 'filter', 'filter' => 'intval'),
            array('_id', 'filter', 'filter' => array('site\frontend\modules\analytics\models\PageView', 'path')),
        );
    }

    public static function path($url)
    {
        return parse_url($url, PHP_URL_PATH);
    }

    public function behaviors()
    {
        return array(
            'timestampBehavior' => array(
                'class' => '\site\common\behaviors\HMongoTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
                'setUpdateOnCreate' => true,
            )
        );
    }

    public function afterSave()
    {
        $entity = $this->getEntity();
        if ($entity !== null) {
            $entity->views = $this->getCounter();
            $entity->update(array('views'));
        }
        parent::afterSave();
    }

    public function getCounter()
    {
        return $this->visits + $this->correction;
    }

    public static function getModel($url)
    {
        $path = self::path($url);
        $model = self::model()->findByPk($path);
        if ($model === null) {
            $model = new PageView();
            $model->_id = $url;
        }
        return $model;
    }

    protected function getEntity()
    {
        foreach ($this->getRoutes() as $pattern => $callback) {
            if (preg_match($pattern, $this->_id, $matches)) {
                return call_user_func($callback, $matches);
            }
        }
        return null;
    }

    private function getRoutes()
    {
        return array(
            '#^/user/\d+/blog/post(\d+)/$#' => function($matches) {
                $id = $matches[1];
                return Content::model()->byEntity('CommunityContent', $id)->find();
            },
            '#^/community/\d+/forum/\w+/(\d+)/$#' => function($matches) {
                $id = $matches[1];
                $a = Content::model()->byEntity('CommunityContent', $id)->find();
                return $a;
            },
        );
    }
} 