<?php

class m160627_080821_post_contents_performance extends CDbMigration
{

    public function up()
    {
        print "add table columns\r\n";
        $this->execute("ALTER TABLE post__contents"
                . " ADD label_section INT NULL COMMENT 'id основного раздела', "
                . " ADD label_subsections varchar(250) NULL COMMENT 'список id подразделов'");
        print "create table index\r\n";
        $this->execute("CREATE INDEX post__contents_label_section_IDX ON happy_giraffe.post__contents (label_section,label_subsections)");
        print "start fil index columns\r\n";
        $c = \site\frontend\modules\posts\commands\FillLables::create();
        $c->actionIndex();
        # Yii::app()->create
        return true;
    }

    public function down()
    {
        $this->execute("ALTER TABLE happy_giraffe.post__contents DROP COLUMN label_section, DROP COLUMN label_subsections");
        return true;
    }

    /*
      // Use safeUp/safeDown to do migration with transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
