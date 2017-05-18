<?php
/**
 * @author Никита
 * @date 02/03/17
 */

namespace site\frontend\modules\geo2\components\fias\update;


class VersionManager
{
    const VERSION_DESTINATION = 'http://fias.nalog.ru/Public/Downloads/Actual/VerDate.txt';
    
    public function isUpdateRequired()
    {
        return $this->getActualVersion() != $this->getCurrentVersion();
    }

    public function setCurrentVersion($version = false)
    {
        $model = new UpdateLog();
        $model->created = date("Y-m-d H:i:s");
        $model->version = $version ? $version : $this->getActualVersion();
        return $model->save();
    }

    public function getCurrentVersion()
    {
        $model = UpdateLog::model()->orderDesc()->findAll(['limit' => 1])[0];
        return $model->version;
    }
    
    public function getActualVersion()
    {
        return file_get_contents(self::VERSION_DESTINATION);
    }
}