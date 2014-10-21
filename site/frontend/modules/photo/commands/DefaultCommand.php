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

        while (\Yii::app()->gearman->worker()->work()) {
            echo "OK\n";
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
        echo "deferredWrite:\n$key\n\n";
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
        echo "createThumbs\n";
    }

    public function actionMigrate()
    {
        PhotoAlbum::model()->deleteAll();
        PhotoAttach::model()->deleteAll();
        PhotoCollection::model()->deleteAll();
        Photo::model()->deleteAll();

        $album = \Album::model()->findByPk(47831);
        $mm = new MigrateManager();
        $mm->moveUserAlbum($album);

    }
} 