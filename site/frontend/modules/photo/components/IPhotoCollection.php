<?php
/**
 * Интерфейс для моделей, которые могут иметь фото-коллекцию
 *
 * Описывает методы, которые необходимы поддерживаться основной моделью для корректной работы коллекции
 *
 * @author Никита
 * @date 03/10/14
 * @todo Скорее всего полностью замещен абстрактной моделью коллекции, подлежит удалению.
 */

namespace site\frontend\modules\photo\components;

interface IPhotoCollection
{
    /**
     * Возвращает подпись коллекции
     *
     * @return string
     */
    public function getCollectionLabel();

    /**
     * Возвращает заголовок коллекции
     *
     * @return string
     */
    public function getCollectionTitle();

    /**
     * Возвращает описание коллекции
     *
     * @return string
     */
    public function getCollectionDescription();
} 