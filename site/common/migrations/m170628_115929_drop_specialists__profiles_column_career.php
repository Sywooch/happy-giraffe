<?php

class m170628_115929_drop_specialists__profiles_column_career extends CDbMigration
{
 
	public function up()
	{
        $runner = new CConsoleCommandRunner();
        $runner->commands = [
            'syncCareer' => [
                'class' => \site\frontend\modules\specialists\commands\SyncCareerCommand::class
            ]
        ];
        
        $code = $runner->run(['yiic', 'syncCareer']);
        
        if ($code === 0)
        {
            $this->execute('ALTER TABLE ' . \site\frontend\modules\specialists\models\SpecialistProfile::model()->tableName() . ' DROP COLUMN career ');
        }
	}

	public function down()
	{
        $this->execute('ALTER TABLE ' . \site\frontend\modules\specialists\models\SpecialistProfile::model()->tableName() . ' ADD COLUMN career TEXT ');
	}
	
}