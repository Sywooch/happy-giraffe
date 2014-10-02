<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 01/10/14
 * Time: 17:17
 */

namespace site\frontend\modules\photo\models;


class ImageStringData extends \CValidator
{


    public $width;
    public $height;
    public $extension;

    protected $type;

    public function rules()
    {
        return array(
            array('type', 'validType')
        );
    }

    public function attributeNames()
    {
        return array(
            'width',
            'height',
            'extension',
        );
    }

    public function __construct($imageString)
    {
        $imageSize = $this->getImageSize($imageString);
        if ($imageSize === false) {
            throw new \CException('Неизвестный формат файла');
        }

        $this->width = $imageSize[0];
        $this->height = $imageSize[1];
        $this->type = $imageSize[2];
    }

    public function validType($attribute)
    {
        if (! in_array($this->$attribute, array_keys(\Yii::app()->getModule('photo')->types))) {
            $this->addError($attribute, 'Загружаются только файлы jpg, png, gif');
        }
    }

    protected function afterValidate()
    {
        $this->extension = $this->getExtension();
        parent::afterValidate();
    }

    protected function getExtension()
    {
        $typeToExtension = \Yii::app()->getModule('photo')->types;
        return $typeToExtension[$this->type];
    }

    protected function getImageSize($imageString)
    {
        $uri = 'data://application/octet-stream;base64,'  . base64_encode($imageString);
        return getimagesize($uri);
    }


} 