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
     * @return mixed
     */
    public function getPreviewText();

    /**
     * @return AlbumPhoto|null
     */
    public function getPreviewPhoto();
} 