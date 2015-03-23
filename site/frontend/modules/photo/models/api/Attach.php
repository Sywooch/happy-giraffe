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

}
