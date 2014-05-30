<?php
/**
 * Интерфейс для моделей, которые могут иметь фото-коллекцию
 *
 * Описывает методы, которые необходимы поддерживаться основной моделью для корректной работы коллекции
 */

namespace components;


interface IPhotoCollection
{
    public function getCollectionLabel();
    public function getCollectionTitle();
    public function getCollectionDescription();
} 