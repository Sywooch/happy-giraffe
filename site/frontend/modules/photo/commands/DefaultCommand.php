<?php
/**
 * Консольная команда модуля
 *
 * Предназначена для обработки отложенных операций сервером очередей
 */

namespace site\frontend\modules\photo\commands;


use site\frontend\modules\photo\models\Photo;

class DefaultCommand extends \CConsoleCommand
{
    /**
     * Основной воркер, должен быть всегда запущен для корректной работы приложения
     */
    public function actionWorker()
    {
        // Эта функция необходима для корректной работы кеш-адаптера DeferredCache, записывает файл в исходную ФС
        \Yii::app()->gearman->worker()->addFunction('deferredWrite', function($job) {
            $data = unserialize($job->workload());
            $key = $data['key'];
            $content = $data['content'];
            \Yii::app()->fs->getAdapter()->getSource()->write($key, $content);
            echo "deferredWrite:\n$key\n\n";
        });

        // Эта функция спакетно создает миниатюры для загруженных/обновленных изображений
        \Yii::app()->gearman->worker()->addFunction('createThumbs', function($job) {
            $photoId = $job->workload();
            $photo = Photo::model()->findByPk($photoId);
            if ($photo !== null) {
                \Yii::app()->thumbs->createAll($photo);
            }
            echo "createThumbs\n";
        });

        while (\Yii::app()->gearman->worker()->work()) {
            echo "OK\n";
        }
    }
} 