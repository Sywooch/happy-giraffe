<?php

class m130906_120615_add_slug_clubs extends CDbMigration
{
    private $_table = 'community__clubs';

    public function up()
    {
        $this->addColumn($this->_table, 'slug', 'varchar(50)');

        $this->execute("
        UPDATE community__clubs SET slug='planning-pregnancy' WHERE id=1;
        UPDATE community__clubs SET slug='pregnancy-and-birth' WHERE id=2;
        UPDATE community__clubs SET slug='babies' WHERE id=3;
        UPDATE community__clubs SET slug='kids' WHERE id=4;
        UPDATE community__clubs SET slug='preschoolers' WHERE id=5;
        UPDATE community__clubs SET slug='schoolers' WHERE id=6;
        UPDATE community__clubs SET slug='cook' WHERE id=7;
        UPDATE community__clubs SET slug='repair-house' WHERE id=8;
        UPDATE community__clubs SET slug='homework' WHERE id=9;
        UPDATE community__clubs SET slug='garden' WHERE id=10;
        UPDATE community__clubs SET slug='pets' WHERE id=11;
        UPDATE community__clubs SET slug='beauty-and-fashion' WHERE id=12;
        UPDATE community__clubs SET slug='health' WHERE id=13;
        UPDATE community__clubs SET slug='wedding' WHERE id=14;
        UPDATE community__clubs SET slug='relations' WHERE id=15;
        UPDATE community__clubs SET slug='needlework' WHERE id=16;
        UPDATE community__clubs SET slug='homeflowers' WHERE id=17;
        UPDATE community__clubs SET slug='auto' WHERE id=18;
        UPDATE community__clubs SET slug='fishing' WHERE id=19;
        UPDATE community__clubs SET slug='travel' WHERE id=20;
        UPDATE community__clubs SET slug='weekends' WHERE id=21;
        UPDATE community__clubs SET slug='holidays' WHERE id=22;
        ");
    }

//planning-pregnancy
//pregnancy-and-birth
//babies
//kids
//preschoolers
//schoolers
//cook
//repair-house
//homework
//garden
//pets
//beauty-and-fashion
//health
//wedding
//relations
//needlework
//homeflowers
//auto
//fishing
//travel
//weekends
//holidays

    public function down()
    {
        $this->dropColumn($this->_table, 'slug');
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