<?php
/**
 * Модель для формирования попапа загрузки фото
 *
 * Занимается валидацией и обработкой данных, необходимых для формирования попапа загрузки фото
 */

namespace site\frontend\modules\photo\models\upload;

class PopupForm extends \CFormModel
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
    public function toJSON()
    {
        return \CJSON::encode($this->attributes);
    }
} 