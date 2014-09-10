<?php
namespace site\frontend\modules\notifications\models;

/**
 * Description of User
 *
 * @author Кирилл
 */
class User extends \EMongoEmbeddedDocument
{
    public $id;
    public $mongoId;
    public $avatar;
    public $link;
}

?>
