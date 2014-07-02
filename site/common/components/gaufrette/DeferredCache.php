<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 02/07/14
 * Time: 16:17
 */

namespace site\common\components\gaufrette;




class DeferredCache extends CustomCache
{
    public $source;

    public function write($key, $content, array $metadata = null)
    {
        $data = array(
            'key' => $key,
            'content' => $content,
        );
        \Yii::app()->gearman->client()->doBackground('defferedWrite', serialize($data));

        return $this->cache->write($key, $content);
    }
} 