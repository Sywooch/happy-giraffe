<?php

class m170502_154656_create_specialists__profile_education_table extends CDbMigration
{
    
    public $tableName = 'specialists__profile_education';
    
    public function safeUp()
    {
        if (Yii::app()->db->schema->getTable($this->tableName, TRUE) === NULL)
        {
            $this->createTable($this->tableName, [
                'id'             => 'int(11) UNSIGNED NOT NULL AUTO_INCREMENT',
                'profile_id'     => 'int(11) UNSIGNED DEFAULT NULL',
                'university_id'  => 'int(11) UNSIGNED DEFAULT NULL',
                'specialization' => 'varchar(100) NULL',
                'end_year'       => 'year NOT NULL',
                'PRIMARY KEY (id)',
            ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
    
            $this->addForeignKey('fk__university_id__specialists__universities_id', $this->tableName, 'university_id', 'specialists__universities', 'id', 'SET NULL', 'CASCADE');
            $this->addForeignKey('fk__profile_id__specialists__profiles_id', $this->tableName, 'profile_id', 'specialists__profiles', 'id', 'CASCADE', 'CASCADE');
        }
    }
    
    public function safeDown()
    {
        $this->dropForeignKey('fk__university_id__specialists__universities_id', $this->tableName);
        $this->dropForeignKey('fk__profile_id__specialists__profiles_id', $this->tableName);
        
        $this->dropTable($this->tableName);
    }
    
}