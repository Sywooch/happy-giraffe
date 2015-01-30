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
            array('_id', 'filter', 'filter' => array($this, 'path')),
        );
    }

    public function path($url)
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

    public function getCounter()
    {
        return $this->visits + $this->correction;
    }

    public static function getModel($url)
    {
        $model = self::model()->findByPk($url);
        if ($model === null) {
            $model = new PageView();
            $model->_id = $url;
        }
        return $model;
    }

    public function getEntity()
    {
        if (preg_match('#user/(?:\d+)/blog/post(\d+)#', $this->_id, $matches)) {
            $id = $matches[1];
            return Content::model()->byEntity('CommunityContent', $id)->find();
        }
        return null;
    }
} 