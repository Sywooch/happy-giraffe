<?php

/**
 * Class m170419_161754_create_specialists__universities_table
 *
 * @author Sergey Gubarev
 */
class m170419_161754_create_specialists__universities_table extends CDbMigration
{
    public $tableName = 'specialists__universities';

	public function up()
	{
        $this->createTable($this->tableName, [
            'id'            => 'int(11) UNSIGNED NOT NULL AUTO_INCREMENT',
            'group_id'      => 'int(11) UNSIGNED NOT NULL',
            'country_id'    => 'int(11) UNSIGNED DEFAULT NULL',
            'city_id'       => 'int(11) UNSIGNED DEFAULT NULL',
            'name'          => 'TEXT NOT NULL',
            'site'          => 'varchar(255) DEFAULT NULL',
            'address'       => 'varchar(255) NOT NULL',
            'PRIMARY KEY (id)'
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_group_id__specialists__groups_id', $this->tableName, 'group_id', 'specialists__groups', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_group_id__geo2__country_id', $this->tableName, 'country_id', 'geo2__country', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_group_id__geo2__city_id', $this->tableName, 'city_id', 'geo2__city', 'id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
        $this->dropForeignKey('fk_group_id__specialists__groups_id', $this->tableName);
        $this->dropForeignKey('fk_group_id__geo2__country_id', $this->tableName);
        $this->dropForeignKey('fk_group_id__geo2__city_id', $this->tableName);

        $this->dropTable($this->tableName);
	}
}