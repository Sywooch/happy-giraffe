<?php

/**
 * изменение commentators__contests, приведение даты к timestamp что бы можно
 * было задавать точные временные ограничения конкурса
 */
class m160630_070937_commentators_contests_date_fix extends CDbMigration
{

    public function up()
    {
        $sql = 'ALTER TABLE commentators__contests'
                . ' MODIFY COLUMN startDate TIMESTAMP NOT NULL,'
                . ' MODIFY COLUMN endDate TIMESTAMP NOT NULL';
        $this->execute($sql);
    }

    public function down()
    {
        $sql = 'ALTER TABLE commentators__contests'
                . ' MODIFY COLUMN startDate DATE NOT NULL,'
                . ' MODIFY COLUMN endDate DATE NOT NULL';
        $this->execute($sql);
        return true;
    }

}
