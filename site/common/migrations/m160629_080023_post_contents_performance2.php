<?php

class m160629_080023_post_contents_performance2 extends CDbMigration
{

    public function up()
    {
        print "add table columns\r\n";
        $this->execute("ALTER TABLE post__tags"
                . " ADD deleted INT DEFAULT 0 NULL, "
                . " ADD add_data TIMESTAMP NULL");
        print "create table index\r\n";
        $this->execute("CREATE INDEX post__tags_labelId_IDX ON post__tags (labelId,deleted,add_data)");
        print "start fil index columns\r\n";
        $this->execute("UPDATE post__tags SET "
                . "`deleted` = (SELECT isRemoved FROM post__contents AS pc WHERE pc.id=contentId ),"
                . "`add_data` = (SELECT FROM_UNIXTIME(dtimeCreate) FROM post__contents AS pc WHERE pc.id=contentId )");
        return true;
    }

    public function down()
    {
        $this->execute("ALTER TABLE post__tags DROP COLUMN deleted, DROP COLUMN add_data");
        return true;
    }

}
