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

class DefaultCommand extends \CConsoleCommand
{
    /**
     * Основной воркер, должен быть всегда запущен для корректной работы приложения.
     */
    public function actionWorker()
    {
        \Yii::app()->gearman->worker()->addFunction('deferredWrite', array($this, 'deferredWrite'));
        \Yii::app()->gearman->worker()->addFunction('createThumbs', array($this, 'createThumbs'));

        while (\Yii::app()->gearman->worker()->work());
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
        $photo = Photo::model()->findByPk($photoId);
        if ($photo !== null) {
            \Yii::app()->thumbs->createAll($photo);
        }
    }

    public function actionMigrate()
    {
        $mm = new MigrateManager();
        $mm->moveUserAlbumsPhotos();
    }

    public function actionSync()
    {
        $local = \Yii::app()->fs->getAdapter()->getCache();
        $source = \Yii::app()->fs->getAdapter()->getSource();
        $dp = new \CActiveDataProvider('site\frontend\modules\photo\models\Photo');
        $iterator = new \CDataProviderIterator($dp, 1000);
        /** @var \site\frontend\modules\photo\models\Photo $photo */
        foreach ($iterator as $photo) {
            $fsPath = $photo->getImageFile()->getOriginalFsPath();
            if ($local->exists($fsPath)) {
                $data = array(
                    'key' => $fsPath,
                    'content' => $local->read($fsPath),
                );
                \Yii::app()->gearman->client()->doBackground('deferredWrite', serialize($data));
                \Yii::app()->gearman->client()->doBackground('createThumbs', $photo->id);
            } else {
                echo $photo->id . "\n";
            }
            \Yii::app()->db->active = false;
            \Yii::app()->db->active = true;
        }
    }
} 