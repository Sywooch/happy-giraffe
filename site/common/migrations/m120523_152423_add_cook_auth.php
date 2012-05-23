<?php

class m120523_152423_add_cook_auth extends CDbMigration
{
    public function up()
    {
        $this->execute("INSERT INTO auth__items VALUES ('cook_ingredients', 0, 'Редактирование ингредиентов', NULL, NULL);");
    }

    public function down()
    {
        echo "m120523_152423_add_cook_auth does not support migration down.\n";
        return false;
    }

}