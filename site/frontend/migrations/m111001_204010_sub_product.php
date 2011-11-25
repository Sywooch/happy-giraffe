<?php
class m111001_204010_sub_product extends CDbMigration
{
    public function up()
    {
        $this->execute("CREATE TABLE shop_product_link (
    link_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    link_main_product_id INT(10) UNSIGNED NOT NULL,
    link_sub_product_id INT(10) UNSIGNED NOT NULL,
    PRIMARY KEY (link_id),
    INDEX link_main_product_id (link_main_product_id)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM;");
        
        if(Yii::app()->hasComponent('cache'))
            Yii::app()->getComponent('cache')->flush();
        
    }
    

    public function down()
    {
        echo "m111001_204010_sub_product does not support migration down.\n";
        return false;
        
        $this->execute("");
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