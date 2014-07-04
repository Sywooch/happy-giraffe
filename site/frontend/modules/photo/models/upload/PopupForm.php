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
        );
    }

    /**
     * Формирует JSON для передачи обработанных данных с клиента
     * @return string JSON для клиента
     */
//    public function toJSON()
//    {
//        return \CJSON::encode($this->attributes);
//    }

    public function getAlbumsJSON()
    {
        return array_map(function($album) {
            /** @var PhotoAlbum $album */
            return array(
                'title' => $album->title,
                'count' => $album->photoCollection->attachesCount,
                'cover' => $album->photoCollection->getCover()->toJSON(),
                'photos' => array_map(function($attach) {
                    return $attach->photo->toJSON();
                }, $album->photoCollection->attaches),
            );
        }, $this->getAlbums());
    }

    /**
     * @return PhotoAlbum[]
     */
    protected function getAlbums()
    {
        return PhotoAlbum::model()->findAll(array(
            'with' => array(
                'photoCollection' => array(
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
                'photoCollection' => array(
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
        );
    }
} 