<?php

class m170628_115929_drop_specialists__profiles_column_career extends CDbMigration
{
	public function up()
	{
	    $this->execute('ALTER TABLE ' . \site\frontend\modules\specialists\models\SpecialistProfile::model()->tableName() . ' DROP COLUMN career ');
	}

	public function down()
	{
        $this->execute('ALTER TABLE ' . \site\frontend\modules\specialists\models\SpecialistProfile::model()->tableName() . ' ADD COLUMN career TEXT ');
	}
}