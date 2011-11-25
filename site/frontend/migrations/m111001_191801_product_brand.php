<?php
class m111001_191801_product_brand extends CDbMigration
{
    public function up()
    {
        $this->execute("CREATE TABLE shop_product_brand (
    brand_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    brand_title VARCHAR(250) NULL DEFAULT NULL,
    brand_text TEXT NULL,
    brand_image VARCHAR(250) NULL DEFAULT NULL,
    PRIMARY KEY (brand_id)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM;");
        
        if(Yii::app()->hasComponent('cache'))
            Yii::app()->getComponent('cache')->flush();
        
    }
    

    public function down()
    {
        echo "m111001_191801_product_brand does not support migration down.\n";
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