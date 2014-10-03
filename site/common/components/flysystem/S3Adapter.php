<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 30/06/14
 * Time: 13:30
 */

namespace site\common\components\flysystem;
use League\Flysystem\Adapter\AwsS3;

class S3Adapter extends AwsS3
{
    public $bucket;
} 