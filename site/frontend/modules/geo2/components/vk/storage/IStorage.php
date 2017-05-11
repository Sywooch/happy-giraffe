<?php

namespace site\frontend\modules\geo2\components\vk\storage;

/**
 * @author Никита
 * @date 09/03/17
 */
interface IStorage
{
    public function insert($model, array $attributes);
}