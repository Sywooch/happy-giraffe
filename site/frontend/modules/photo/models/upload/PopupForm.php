<?php
/**
 * Модель для формирования попапа загрузки фото
 *
 * Занимается валидацией и обработкой данных, необходимых для формирования попапа загрузки фото
 */

namespace site\frontend\modules\photo\models\upload;

use site\frontend\modules\photo\models\PhotoAlbum;

class PopupForm extends \CFormModel implements \IHToJSON
{
    /**
     * @var bool мультизагрузочная форма
     */
    public $multiple;

    /**
     * @var int ID пользователя
     */
    public $userId;

    /**
     * @var int ID коллекции
     */
    public $collectionId;

    /**
     * Фильтр преобразования строки в логической значение
     * @param $val string
     * @return bool
     */
    public function setMultiple($val)
    {
        return ($val === 'true') ? true : false;
    }

    function rules()
    {
        return array(
            array('multiple', 'filter', 'filter' => array($this, 'setMultiple')),
            array('multiple', 'boolean'),
            array('collectionId', 'safe'),
        );
    }

    /**
     * @return PhotoAlbum[]
     */
    protected function getAlbums()
    {
        return PhotoAlbum::model()->user($this->userId)->findAll(array(
            'with' => array(
                'photoCollections' => array(
                    'scopes' => 'notEmpty',
                    'with' => 'attachesCount',
                ),
            ),
        ));
    }

    public function output()
    {
        return \HJSON::encode(array(
            'form' => $this,
            'albums' => $this->getAlbums(),
        ), array(
            'site\frontend\modules\photo\models\PhotoAlbum' => array(
                'id',
                'title',
                'description',
                'photoCollections' => array(
                    'site\frontend\modules\photo\models\PhotoCollection' => array(
                        'id',
                        '(int)attachesCount',
                        'cover',
                    ),
                ),
            ),
        ));
    }

    public function toJSON()
    {
        return array(
            'multiple' => (bool) $this->multiple,
            'collectionId' => $this->collectionId,
        );
    }
} 