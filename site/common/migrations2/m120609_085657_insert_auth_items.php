<?php

class m120609_085657_insert_auth_items extends CDbMigration
{
    public function up()
    {
        $this->execute("INSERT INTO auth__items VALUES
  ('cook_choose', 0, 'Кулинария как выбрать', NULL, NULL),
  ('cook_spices', 0, 'Кулинария специи', NULL, NULL);");
	}

    public function down()
    {
        echo "m120609_085657_insert_auth_items does not support migration down.\n";
        return false;
    }
}