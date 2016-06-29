<?php
/**
 * добавление колонок в облако тегов для построение индекса в нём, добавляет 
 * колонки в таблицу post__tags:
 * deleted - пометка о том что запись с которой в post__contents удалена (продублировано)
 * add_data - время создания записи post__contents (продублировано)
 * выборка подразумевает использовать запросы в таком виде:
 * SELECT sql_no_cache * 
FROM post__contents AS pc 
WHERE pc.id= (
	SELECT pt.contentId 
	FROM post__tags AS pt 
	WHERE pt.labelId in (6282, 187, 192, 6752, 18319) 
		and pt.deleted=0
		and pt.add_data < FROM_UNIXTIME(1380823242)
	GROUP BY pt.contentId 
	HAVING COUNT(pt.contentId) = 5 
	ORDER BY pt.add_data DESC
	LIMIT 1;
 * 
 SELECT sql_no_cache * 
FROM `post__contents` `t` 
JOIN (
	SELECT pt.contentId 
	FROM post__tags AS pt 
	WHERE pt.labelId in (18319, 187) 
	and pt.deleted=0
	GROUP BY pt.contentId HAVING (count(pt.contentId) = 2)
	ORDER BY pt.add_data
	LIMIT 10 OFFSET 130
) AS tmp ON (tmp.contentId=t.id) ;
);
 */
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
