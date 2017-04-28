<?php

class m170421_114023_create_specialists__profile_career_table extends CDbMigration
{
    public $tableName = 'specialists__profile_career';

	public function up()
	{
        $this->createTable($this->tableName, [
            'id'            => 'int(11) UNSIGNED NOT NULL AUTO_INCREMENT',
            'city_id'       => 'int(11) UNSIGNED DEFAULT NULL',
            'place'         => 'varchar(255) NOT NULL',
            'position'      => 'varchar(100) NULL',
            'start_year'    => 'year NOT NULL',
            'end_year'      => 'year NOT NULL',
            'PRIMARY KEY (id)'
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_city_id__geo2__city_id', $this->tableName, 'city_id', 'geo2__city', 'id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
        $this->dropForeignKey('fk_city_id__geo2__city_id', $this->tableName);

        $this->dropTable($this->tableName);
	}
}