<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 05/06/14
 * Time: 16:05
 */

namespace site\frontend\modules\photo\models\upload;

use site\frontend\modules\photo\components\FileHelper;
use site\frontend\modules\photo\components\PathManager;
use site\frontend\modules\photo\models\Photo;
use site\frontend\modules\photo\models\PhotoCreate;


abstract class UploadForm extends \CFormModel
{
    abstract public function populate();

    /**
     * @var PhotoCreate
     */
    protected $photo;

    public function attributeLabels()
    {
        return array(
            'photos' => 'Изображения',
        );
    }

    public function rules()
    {
        return array(

        );
    }

    public function save()
    {
        $this->populate();

        $success = $this->validate() && $this->photo->save();
        $data = compact('success');
        if ($success) {
            $data['attributes'] = \CMap::mergeArray($this->photo->attributes, array(
                'imageUrl' => $this->photo->getImageUrl(),
                'previewUrl' => $this->getPreview(),
            ));
        }

        return \CJSON::encode($data);
    }

    protected function getPreview()
    {
        $image = \Yii::app()->phpThumb->create($this->photo->getImagePath());
        $image->resize(150, 110);
        $name = $this->photo->getImagePath();
        $name = str_replace($this->photo->fs_name, $this->photo->fs_name . '_preview', $name);
        $image->save($name);
        $url = $this->photo->getImageUrl();
        $url = str_replace($this->photo->fs_name, $this->photo->fs_name . '_preview', $url);
        return $url;
    }
} 