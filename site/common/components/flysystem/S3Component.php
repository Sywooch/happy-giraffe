<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 30/06/14
 * Time: 12:55
 */

namespace site\common\components\flysystem;
use Aws\S3\S3Client;

class S3Component extends BaseComponent
{
    /**
     * @var string AWSAccessKeyId
     */
    public $key;

    /**
     * @var string AWSSecretKey
     */
    public $secret;

    /**
     * @var string корзина
     */
    public $bucket;

    /**
     * @var string префикс
     */
    public $prefix;

    /**
     * @return S3Adapter
     */
    protected function getAdapter()
    {
        return new S3Adapter($this->getClient(), $this->bucket, $this->prefix);
    }

    /**
     * @return S3Client
     */
    protected function getClient()
    {
        return S3Client::factory(array(
            'key'    => $this->key,
            'secret' => $this->secret,
        ));
    }
} 