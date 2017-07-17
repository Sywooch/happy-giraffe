<?php

class m170426_103050_add_column__country_id__to__specialists__profile_career extends CDbMigration
{
	public function up()
	{
	    $this->addColumn('specialists__profile_career', 'country_id', 'int(11) UNSIGNED DEFAULT NULL');

        $this->addForeignKey('fk_country_id__geo2__country_id', 'specialists__profile_career', 'country_id', 'geo2__country', 'id', 'SET NULL', 'CASCADE');
	}

	public function down()
	{
		$this->dropForeignKey('fk_country_id__geo2__country_id', 'specialists__profile_career');

		$this->dropColumn('specialists__profile_career', 'country_id');
	}
}