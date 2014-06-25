<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 11/06/14
 * Time: 15:45
 */

namespace site\frontend\modules\photo\models\upload;


use site\frontend\modules\photo\models\PhotoCreate;

class ByUrlUploadForm extends UploadForm
{
    public $url;

    public function rules()
    {
        return \CMap::mergeArray(parent::rules(), array(
            array('url', 'url'),
        ));
    }

    public function populate()
    {
        $image = file_get_contents($this->url);
        $tmpHandle = tmpfile();
        fwrite($tmpHandle, $image);
        $metaData = stream_get_meta_data($tmpHandle);



        $tmpFilename = $metaData['uri'];



        $this->photos[] = new PhotoCreate($tmpFilename, basename($this->url));
    }
} 