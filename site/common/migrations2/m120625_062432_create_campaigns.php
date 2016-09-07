<?php

class m120625_062432_create_campaigns extends CDbMigration
{
    public function up()
    {
        $this->execute("CREATE TABLE mail__campaigns(
          id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
          subject VARCHAR(100) NOT NULL,
          body TEXT NOT NULL,
          author_id INT(10) UNSIGNED NOT NULL,
          created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (id),
          CONSTRAINT FK_mail__campaigns_users_id FOREIGN KEY (author_id)
          REFERENCES users (id) ON DELETE RESTRICT ON UPDATE RESTRICT
        )
        ENGINE = INNODB
        AUTO_INCREMENT = 1
        CHARACTER SET utf8
        COLLATE utf8_general_ci;");
    }

    public function down()
    {
        echo "m120625_062432_create_campaigns does not support migration down.\n";
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