<?php

class m120120_062849_add_product_fks extends CDbMigration
{
    private $_table = 'shop_product';

	public function up()
	{
        $this->execute('SET foreign_key_checks = 0;');
        $this->addForeignKey($this->_table.'_category_fk', $this->_table, 'product_category_id',
            'shop_category', 'category_id','CASCADE',"CASCADE");
        $this->addForeignKey($this->_table.'_brand_fk', $this->_table, 'product_brand_id',
            'shop_product_brand', 'brand_id','CASCADE',"CASCADE");

        $this->_table = 'shop_product_comment';
        $this->addForeignKey($this->_table.'_product_fk', $this->_table, 'product_id', 'shop_product', 'product_id','CASCADE',"CASCADE");

        $this->_table = 'shop_product_eav';
        $this->addForeignKey($this->_table.'_product_fk', $this->_table, 'eav_product_id', 'shop_product', 'product_id','CASCADE',"CASCADE");

        $this->_table = 'shop_product_eav_text';
        $this->addForeignKey($this->_table.'_product_fk', $this->_table, 'eav_product_id', 'shop_product', 'product_id','CASCADE',"CASCADE");

        $this->_table = 'shop_product_image';
        $this->addForeignKey($this->_table.'_product_fk', $this->_table, 'image_product_id', 'shop_product', 'product_id','CASCADE',"CASCADE");

        $this->_table = 'shop_product_link';
        $this->addForeignKey($this->_table.'_product_fk', $this->_table, 'link_main_product_id', 'shop_product', 'product_id','CASCADE',"CASCADE");
        $this->addForeignKey($this->_table.'_sub_product_fk', $this->_table, 'link_sub_product_id', 'shop_product', 'product_id','CASCADE',"CASCADE");

        $this->_table = 'shop_product_video';
        $this->addForeignKey($this->_table.'_product_fk', $this->_table, 'product_id', 'shop_product', 'product_id','CASCADE',"CASCADE");
        $this->execute('SET foreign_key_checks = 1;');
	}

	public function down()
	{
        $this->execute('SET foreign_key_checks = 0;');
        $this->dropForeignKey($this->_table.'_category_fk', $this->_table);
        $this->dropForeignKey($this->_table.'_brand_fk', $this->_table);

        $this->_table = 'shop_product_comment';
        $this->dropForeignKey($this->_table.'_product_fk', $this->_table);

        $this->_table = 'shop_product_eav';
        $this->dropForeignKey($this->_table.'_product_fk', $this->_table);

        $this->_table = 'shop_product_eav_text';
        $this->dropForeignKey($this->_table.'_product_fk', $this->_table);

        $this->_table = 'shop_product_image';
        $this->dropForeignKey($this->_table.'_product_fk', $this->_table);

        $this->_table = 'shop_product_link';
        $this->dropForeignKey($this->_table.'_product_fk', $this->_table);
        $this->dropForeignKey($this->_table.'_sub_product_fk', $this->_table);

        $this->_table = 'shop_product_video';
        $this->dropForeignKey($this->_table.'_product_fk', $this->_table);
        $this->execute('SET foreign_key_checks = 1;');
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