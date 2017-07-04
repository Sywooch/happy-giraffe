<?php

class m170704_085221_drop_specialists__profiles_column_education extends CDbMigration
{
 
	public function up()
    {
        $this->execute('ALTER TABLE ' . \site\frontend\modules\specialists\models\SpecialistProfile::model()->tableName() . ' DROP COLUMN education');
	}

	public function down()
	{
        $this->execute('ALTER TABLE ' . \site\frontend\modules\specialists\models\SpecialistProfile::model()->tableName() . ' ADD COLUMN education TEXT');
	}
	
}