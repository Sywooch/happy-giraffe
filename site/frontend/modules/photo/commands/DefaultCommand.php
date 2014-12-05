<?php
/**
 * Консольная команда модуля.
 *
 * Предназначена для обработки отложенных операций сервером очередей.
 *
 * @author Никита
 * @date 03/10/14
 */

namespace site\frontend\modules\photo\commands;
use site\frontend\modules\photo\components\MigrateManager;
use site\frontend\modules\photo\models\Photo;
use site\frontend\modules\photo\models\PhotoAlbum;
use site\frontend\modules\photo\models\PhotoAttach;
use site\frontend\modules\photo\models\PhotoCollection;



register_shutdown_function(function() {
    $errfile = "unknown file";
    $errstr  = "shutdown";
    $errno   = E_CORE_ERROR;
    $errline = 0;

    $error = error_get_last();

    if( $error !== NULL) {
        $errno   = $error["type"];
        $errfile = $error["file"];
        $errline = $error["line"];
        $errstr  = $error["message"];

        echo time(); echo "\n";
        echo $errno; echo "\n";
        echo $errfile; echo "\n";
        echo $errline; echo "\n";
        echo $errstr; echo "\n";

    }
});

class DefaultCommand extends \CConsoleCommand
{
    /**
     * Основной воркер, должен быть всегда запущен для корректной работы приложения.
     */
    public function actionWorker()
    {
        \Yii::app()->gearman->worker()->addFunction('deferredWrite', array($this, 'deferredWrite'));
        \Yii::app()->gearman->worker()->addFunction('updatePhotoPostPhoto', array($this, 'updatePhotoPostPhoto'));

        for ($i = 0; $i < 100; $i++) {
            \Yii::app()->gearman->worker()->work();
        }
    }

    /**
     * Эта функция необходима для корректной работы кеш-адаптера DeferredCache, записывает файл в исходную ФС.
     * @param \GearmanJob $job
     */
    public function deferredWrite(\GearmanJob $job)
    {
        $data = unserialize($job->workload());
        $key = $data['key'];
        $content = $data['content'];
        \Yii::app()->fs->getAdapter()->getSource()->write($key, $content);
    }

    /**
     * Эта функция пакетно создает миниатюры для загруженных/обновленных изображений.
     * @param \GearmanJob $job
     */
    public function createThumbs(\GearmanJob $job)
    {
        $photoId = $job->workload();
        \Yii::app()->db->active = false;
        \Yii::app()->db->active = true;
        $photo = Photo::model()->findByPk($photoId);
        if ($photo !== null) {
            \Yii::app()->thumbs->createAll($photo);
        }
    }

    public function updatePhotoPostPhoto(\GearmanJob $job)
    {
        $data = unserialize($job->workload());
        $oldPhoto = \AlbumPhoto::model()->findByPk($data['oldPhotoId']);
        if ($oldPhoto !== null) {
            MigrateManager::updatePhoto($oldPhoto, $data['attributes']);
        }
    }

    public function actionMigrate($id = null)
    {
        echo time();
        \Yii::app()->db->createCommand('SET SESSION wait_timeout = 28800;')->execute();
        $mm = new MigrateManager();
        $mm->moveUserAlbumsPhotos($id);
    }

    public function actionSync()
    {
        $local = \Yii::app()->fs->getAdapter()->getCache();
        $source = \Yii::app()->fs->getAdapter()->getSource();

        $dp = new \CActiveDataProvider('site\frontend\modules\photo\models\Photo', array(
            'criteria' => array(
                'order' => 'id ASC',
            ),
        ));

        $iterator = new \CDataProviderIterator($dp, 100);
        /** @var \site\frontend\modules\photo\models\Photo $photo */
        foreach ($iterator as $i => $photo) {
            echo $i . ' - originals - ' . $photo->id . "\n";
            $fsPath = $photo->getImageFile()->getOriginalFsPath();
            if ($local->exists($fsPath)) {
                if (! $source->exists($fsPath)) {
                    $bytesWritten = $source->write($fsPath, $local->read($fsPath));
                    if ($bytesWritten === false) {
                        echo "cant write original\n";
                    }
                }
            } else {
                echo "no local file\n";
            }
            \Yii::app()->db->active = false;
            \Yii::app()->db->active = true;
        }

        $iterator = new \CDataProviderIterator($dp, 100);
        /** @var \site\frontend\modules\photo\models\Photo $photo */
        foreach ($iterator as $i => $photo) {
            echo $i . ' - thumbs - ' . $photo->id . "\n";
            \Yii::app()->thumbs->createAll($photo);
        }
    }
} 