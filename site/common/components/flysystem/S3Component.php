<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 30/06/14
 * Time: 12:55
 */

namespace site\common\components\flysystem;
use Aws\S3\S3Client;
use League\Flysystem\Filesystem;

class S3Component extends BaseComponent
{
    public $key;
    public $secret;
    public $bucket;
    public $prefix;

    protected function getAdapter()
    {
        $client = S3Client::factory(array(
            'key'    => $this->key,
            'secret' => $this->secret,
        ));

        return new Filesystem(new S3Adapter($client, $this->bucket, $this->prefix));
    }
} 