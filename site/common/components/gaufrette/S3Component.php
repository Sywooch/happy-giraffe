<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 01/07/14
 * Time: 21:04
 */

namespace site\common\components\gaufrette;
use Aws\S3\S3Client;
use Gaufrette\Adapter\AwsS3;

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
     * @return Aws3
     */
    protected function getAdapter()
    {
        return new AwsS3($this->getClient(), $this->bucket);
    }

    protected function getClient()
    {
        return S3Client::factory(array(
            'key'    => $this->key,
            'secret' => $this->secret,
        ));
    }
} 