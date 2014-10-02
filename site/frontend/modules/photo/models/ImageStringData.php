<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 01/10/14
 * Time: 17:17
 */

namespace site\frontend\modules\photo\models;


class ImageStringData extends \CModel
{
    public $type;
    public $width;
    public $height;

    protected $imageString;
    protected $imageSize;

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
            'type',
        );
    }

    public function __construct($imageString)
    {
        $imageSize = $this->getImageSize($imageString);
        if ($imageSize !== false) {
            $this->width = $this->imageSize[0];
            $this->height = $this->imageSize[1];
            $this->type = $this->imageSize[2];
        }
    }

    public function validType($attribute)
    {
        if (! in_array($this->$attribute, array(IMAGETYPE_JPEG, IMAGETYPE_GIF, IMAGETYPE_PNG))) {
            $this->addError($attribute, 'Загружаются только файлы jpg, png, gif');
        }
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