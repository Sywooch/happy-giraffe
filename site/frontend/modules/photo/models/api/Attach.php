<?php

namespace site\frontend\modules\photo\models\api;

/**
 * Description of Photo
 *
 * @author Кирилл
 */
class Attach extends \site\frontend\components\api\models\ApiModel
{

    public $api = 'photo/collections';
    protected $_photo = null;

    /**
     * @param string $className
     * @return \site\frontend\modules\photo\models\api\Collection
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function attributeNames()
    {
        return array(
            'id',
            'position',
            'photo',
            'url',
            'index',
        );
    }

    public function findByCollection($collectionId, $offset)
    {
        $model = null;
        try {
            $data = $this->request('getAttaches', array(
                'collectionId' => $collectionId,
                'offset' => $offset,
                'length' => 1,
                'circular' => false,
            ));
            if (isset($data['success']) && $data['success'] && isset($data['data']) && isset($data['data']['attaches']) && sizeof($data['data']['attaches']) == 1) {
                $model = new self();
                foreach ($data['data']['attaches'][0] as $k => $v) {
                    $model->$k = $v;
                }
            } else {
                $data = null;
            }
        } catch (\Exception $e) {
            $data = null;
        }
        return $model;
    }

    public function findAllByCollection($collectionId)
    {
        $models = array();
        try {
            $data = $this->request('getAttaches', array(
                'collectionId' => $collectionId,
                'offset' => 0,
                'length' => null,
                'circular' => false,
            ));
            if (isset($data['success']) && $data['success'] && isset($data['data']) && isset($data['data']['attaches'])) {
                foreach ($data['data']['attaches'] as $attach) {
                    $model = new self();
                    foreach ($attach as $k => $v) {
                        $model->$k = $v;
                    }
                    $models[] = $model;
                }
            } else {
                $data = null;
            }
        } catch (\Exception $e) {
            $data = null;
        }
        return $models;
    }

    public function getPhotoModel()
    {
        if (is_null($this->_photo)) {
            $this->_photo = new \site\frontend\modules\photo\models\Photo();
            $this->_photo->fromJSON($this->photo);
        }

        return $this->_photo;
    }

}
