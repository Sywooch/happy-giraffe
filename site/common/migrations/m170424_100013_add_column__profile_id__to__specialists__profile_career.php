<?php

/**
 * Class m170424_100013_add_column__profile_id__to__specialists__profile_career
 *
 * @author Sergey Gubarev
 */
class m170424_100013_add_column__profile_id__to__specialists__profile_career extends CDbMigration
{
	public function up()
	{
        $this->addColumn('specialists__profile_career', 'profile_id', 'int(11) unsigned not null');

        $this->addForeignKey('fk_profile_id__specialists__profiles_id', 'specialists__profile_career', 'profile_id', 'specialists__profiles', 'id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
        $this->dropForeignKey('fk_profile_id__specialists__profiles_id', 'specialists__profile_career');

	    $this->dropColumn('specialists__profile_career', 'profile_id');
	}
}