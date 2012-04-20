<?php

class m120417_064433_rename_more extends CDbMigration
{
	public function up()
	{
        $this->renameTable('report', 'reports');
        $this->renameTable('placentaThickness', 'placenta_thickness');

        $fk = 'SELECT `CONSTRAINT_NAME`
              FROM `information_schema`.`REFERENTIAL_CONSTRAINTS`
              WHERE `TABLE_NAME` = "name" AND `REFERENCED_TABLE_NAME` = "name_group" AND CONSTRAINT_SCHEMA = "happy_giraffe"';
        $fk = Yii::app()->db->createCommand($fk)->queryScalar();
        $this->dropForeignKey($fk, 'name');
        $this->dropColumn('name', 'name_group_id');
        $this->dropColumn('name', 'sweet');
        $this->dropColumn('name', 'middle_names');
        $this->dropColumn('name', 'options');

        $this->renameTable('name', 'name__names');
        $this->renameTable('name_famous', 'name__famous');
        $this->renameTable('name_likes', 'name__likes');
        $this->renameTable('name_middle', 'name__middle_names');
        $this->renameTable('name_option', 'name__options');
        $this->renameTable('name_saint_date', 'name__saint_dates');
        $this->renameTable('name_stats', 'name__stats');
        $this->renameTable('name_sweet', 'name__sweets');

        $this->dropTable('name_group');
	}

	public function down()
	{
		echo "m120417_064433_rename_more does not support migration down.\n";
		return false;
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