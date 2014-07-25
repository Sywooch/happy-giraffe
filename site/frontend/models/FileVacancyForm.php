<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 20/06/14
 * Time: 17:33
 */

class FileVacancyForm extends VacancyForm
{
    const CV_PATH = 'webroot.uploads.cv';

    public $cv;
    public $cvUrl;

    public $fullName = 'Василий Пупкин';
    public $email = 'vasya.pupkin@gmail.com';
    public $phoneNumber = '+7 (905) 123-45-67';

//    public function rules()
//    {
//        return CMap::mergeArray(parent::rules(), array(
//            array('cv', 'file', 'types' => array('txt', 'doc', 'docx', 'pdf', 'odt')),
//        ));
//    }

    public function attributeLabels()
    {
        return CMap::mergeArray(parent::attributeLabels(), array(
            'cv' => 'Резюме',
        ));
    }

    public function send()
    {
        die('13');
    }

    public function saveCv()
    {
        $file = CUploadedFile::getInstance($this, 'cv');
        $path = self::getCvPath();

        if (! is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $fileName = md5_file($file->getTempName()) . '.' . $file->getExtensionName();
        if ($file->saveAs($path . DIRECTORY_SEPARATOR . $fileName)) {
            $this->cvUrl = Yii::app()->baseUrl . '/uploads/cv/' . $fileName;
            echo $this->cvUrl;
            die;
        }
    }

    public static function getCvPath()
    {
        return Yii::getPathOfAlias(self::CV_PATH);
    }
} 