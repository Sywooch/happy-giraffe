<?php
/**
 * Костыль, замещающий функцию getimagesizefromstring, которая есть в PHP 5.4, но нет в PHP 5.3
 *
 * @author Никита
 * @date 03/10/14
 * @todo Убрать как только перейдем на PHP 5.4
 */

class ImageSizeHelper
{
    public static function getImageSize($imageString)
    {
        $uri = 'data://application/octet-stream;base64,'  . base64_encode($imageString);
        return getimagesize($uri);
    }
} 