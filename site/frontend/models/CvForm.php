<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 20/06/14
 * Time: 19:46
 */

class CvForm extends CFormModel
{
    const CV_PATH = 'webroot.upload.cv';

    /**
     * @var CUploadedFile
     */
    public $cv;
    protected $cvUrl;

    public function rules()
    {
        return array(
            array('cv', 'file', 'types' => array('txt', 'doc', 'docx', 'pdf', 'odt')),
        );
    }

    public function __construct()
    {
        $this->cv = CUploadedFile::getInstanceByName('cv');
    }

    public function save()
    {
        $path = self::getCvPath();

        if (! is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $fileName = md5_file($this->cv->getTempName()) . '.' . $this->cv->getExtensionName();
        if ($this->cv->saveAs($path . DIRECTORY_SEPARATOR . $fileName)) {
            $this->cvUrl = Yii::app()->getBaseUrl(true) . '/upload/cv/' . $fileName;
            return true;
        }
        return false;
    }

    public function result()
    {
        return CJSON::encode(array(
            'name' => $this->cv->getName(),
            'url' => $this->cvUrl,
        ));
    }

    protected static function getCvPath()
    {
        return Yii::getPathOfAlias(self::CV_PATH);
    }
} 