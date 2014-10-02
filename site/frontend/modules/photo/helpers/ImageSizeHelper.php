<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 02/10/14
 * Time: 17:54
 */

class ImageSizeHelper
{
    public static function getImageSize($imageString)
    {
        $uri = 'data://application/octet-stream;base64,'  . base64_encode($imageString);
        return getimagesize($uri);
    }
} 