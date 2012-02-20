<?php
class m120220_133900_rights_fix extends CDbMigration
{
	public function up()
	{
		$this->execute("INSERT INTO  `happy_giraffe`.`auth_item` (
`name` ,
`type` ,
`description` ,
`bizrule` ,
`data`
)
VALUES (
'editor',  '0',  'редактор, осталось от старой системы', NULL , NULL
), (
'moder',  '0',  'модератор, осталось от старой системы', NULL , NULL
);


");
		$this->insert('auth_assignment', array(
            'itemname'=>'editor',
            'userid'=>'9990'
        ));
        $this->insert('auth_assignment', array(
            'itemname'=>'editor',
            'userid'=>'9991'
        ));
	}
	

	public function down()
	{
		$this->execute("DELETE FROM `happy_giraffe`.`auth_item` WHERE `auth_item`.`name` = 'editor' LIMIT 1;
DELETE FROM `happy_giraffe`.`auth_item` WHERE `auth_item`.`name` = 'moder' LIMIT 1;");
	}
}
