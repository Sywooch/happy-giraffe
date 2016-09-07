<?php

class m120605_072842_alter_album_photo_attaches extends CDbMigration
{
    public function up()
    {
        $sql = "ALTER TABLE `album__photo_attaches` CHANGE `entity` `entity` ENUM('Baby','Comment','ContestWork','User','UserPartner','CookDecoration') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL";
        $this->execute($sql);
    }

    public function down()
    {
        echo "m120605_072842_alter_album_photo_attaches does not support migration down.\n";
        return false;
    }
}