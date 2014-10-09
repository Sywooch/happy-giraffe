<?php
/**
 * Промежуточный класс абстрактной фотоколлекции
 *
 * Этот код не в PhotoCollection, потому что если сделать абстрактным родителя, нельзя будет обычным способом создавать
 * новую модель ActiveRecord.
 *
 * @author Никита
 * @date 03/10/14
 */

namespace site\frontend\modules\photo\models\collections;
use site\frontend\modules\photo\models\PhotoAttach;
use site\frontend\modules\photo\models\PhotoCollection;

abstract class PhotoCollectionAbstract extends PhotoCollection
{
    abstract public function getCollectionLabel();
    abstract public function getCollectionTitle();
    abstract public function getCollectionDescription();
} 