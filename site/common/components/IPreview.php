<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 28/04/14
 * Time: 12:36
 */

interface IPreview
{
    /**
     * @param int $length   Длина текста для превью
     * @param string $etc   Окончание строки
     * @return string       Текст модели для первью
     */
    public function getPreviewText($length = 128, $etc = '...');

    /**
     * @return AlbumPhoto|null
     */
    public function getPreviewPhoto();
} 