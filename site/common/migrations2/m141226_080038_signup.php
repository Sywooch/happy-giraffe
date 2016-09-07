<?php

class m141226_080038_signup extends CDbMigration
{
	public function up()
	{
        $this->execute("UPDATE users
SET status = 1
WHERE id IN (SELECT maxId
FROM (
    SELECT max(id) AS maxId
    FROM users
    WHERE activation_code != '' AND status = 0
    GROUP BY email
) src);");
	}

	public function down()
	{
		echo "m141226_080038_signup does not support migration down.\n";
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