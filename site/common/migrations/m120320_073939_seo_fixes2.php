<?php

class m120320_073939_seo_fixes2 extends CDbMigration
{
	public function up()
	{
        $this->delete('seo__keywords');
        $this->executeFile(Yii::getPathOfAlias('site'). '/common/migrations/seo__keywords.txt');
        $this->executeFile(Yii::getPathOfAlias('site'). '/common/migrations/seo__key_stats.txt');
	}

    public function executeFile($filePath) {
        $sql = file_get_contents($filePath);
        $parts = explode(');'."\n", $sql);
        foreach($parts as $part)
            if (trim($part) != '')
                $this->execute($part.');');
    }

	public function down()
	{

	}
}