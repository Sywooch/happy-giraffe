<?php

class m120609_210450_rename_seo_tables extends CDbMigration
{
    private $_table = '';

	public function up()
	{
        preg_match('/host=([^;]+);/', Yii::app()->db->connectionString, $matches);
        $host = $matches[1];
        $lnk = mysql_connect($host, Yii::app()->db->username, Yii::app()->db->password)
            or die ('Not connected : ' . mysql_error());

        if (mysql_select_db('happy_giraffe_seo', $lnk)) {
            $this->setDbConnection(Yii::app()->db_seo);

            $this->renameTable('baby_stats__browser', 'sites__browsers');
            $this->renameTable('baby_stats__browser_stats', 'sites__browser_visits');
            $this->renameTable('baby_stats__key_stats', 'sites__keywords_visits');
            $this->renameTable('baby_stats__pages_stats', 'sites__pages_visits');
            $this->renameTable('baby_stats__site', 'sites__sites');
            $this->renameTable('baby_stats__site_pages', 'sites__pages');
            $this->dropTable('baby_stats__stats');
            $this->renameTable('baby_stats__visits', 'sites__statistics');
            $this->renameTable('baby_stats__visits_names', 'sites__statistic_types');
        }
	}

	public function down()
	{
		echo "m120609_210450_rename_seo_tables does not support migration down.\n";
		return false;
	}
}