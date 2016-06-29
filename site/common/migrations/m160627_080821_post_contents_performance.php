<?php

/**
 * добавление колонок label_section и label_subsections для выборки по ним
 * и незадействовании облака тегов, выборки должны делаться по средствам FIND_IN_SET
 * label_section - конкретный раздел (форумы, блоги, баз, ...)
 * label_subsections - список тэгов
 * SELECT sql_no_cache * 
  FROM post__contents AS pc
  WHERE
  pc.isRemoved = 0
  AND (pc.dtimePublication>1380823242)
  and FIND_IN_SET(6282, pc.label_subsections)
  and FIND_IN_SET(187, pc.label_subsections)
  and FIND_IN_SET(192, pc.label_subsections)
  and FIND_IN_SET(6752, pc.label_subsections)
  and FIND_IN_SET(18319, pc.label_subsections)
  ORDER BY pc.dtimePublication ASC
  LIMIT 1;
 * 
 * после тестов данный метод показал падение производительности при обработке 
 * длинных списков постов
 */
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
        $this->execute("CREATE INDEX post__contents_isRemoved_IDX ON happy_giraffe.post__contents (isRemoved,label_subsections)");
        print "start fil index columns\r\n";
        $c = new \site\frontend\modules\posts\commands\FillLables('migrate', new CConsoleCommandRunner);
        $c->actionIndex();
        return true;
    }

    public function down()
    {
        $this->execute("ALTER TABLE post__contents DROP COLUMN label_section, DROP COLUMN label_subsections");
        return true;
    }

}
