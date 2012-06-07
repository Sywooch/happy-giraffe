<?php

class m120607_081705_update_ingredients extends CDbMigration
{
    public function up()
    {
        $this->dropColumn('cook__ingredients', 'weight');
    }

    public function down()
    {
        echo "m120607_081705_update_ingredients does not support migration down.\n";
        return false;
    }
}