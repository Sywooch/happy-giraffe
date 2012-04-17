<?php

class m120416_123301_rename_shop extends CDbMigration
{
	public function up()
	{
        $this->renameTable('shop_category', 'shop__category');
        $this->renameTable('shop_category_attributes_map', 'shop__category_attributes_map');
        $this->renameTable('shop_category_attribute_set_map', 'shop__category_attribute_set_map');
        $this->renameTable('shop_delivery', 'shop__delivery');
        $this->renameTable('shop_delivery_cities', 'shop__delivery_cities');
        $this->renameTable('shop_delivery_edpd', 'shop__delivery_edpd');
        $this->renameTable('shop_delivery_edpd_tarif', 'shop__delivery_edpd_tarif');
        $this->renameTable('shop_delivery_edpd_tarifzone', 'shop__delivery_edpd_tarifzone');
        $this->renameTable('shop_delivery_edzpm', 'shop__delivery_edzpm');
        $this->renameTable('shop_delivery_edzpm_city_zone_link', 'shop__delivery_edzpm_city_zone_link');
        $this->renameTable('shop_delivery_edzpm_zone', 'shop__delivery_edzpm_zone');
        $this->renameTable('shop_delivery_egruzovozoff', 'shop__delivery_egruzovozoff');
        $this->renameTable('shop_delivery_egruzovozofftarif', 'shop__delivery_egruzovozofftarif');
        $this->renameTable('shop_delivery_epickpoint', 'shop__delivery_epickpoint');
        $this->renameTable('shop_delivery_epickpointtarif', 'shop__delivery_epickpointtarif');
        $this->renameTable('shop_delivery_regions', 'shop__delivery_regions');
        $this->renameTable('shop_order', 'shop__order');
        $this->renameTable('shop_order_adress', 'shop__order_adress');
        $this->renameTable('shop_order_item', 'shop__order_item');
        $this->renameTable('shop_order_save', 'shop__order_save');
        $this->renameTable('shop_order_save_item', 'shop__order_save_item');
        $this->renameTable('shop_product', 'shop__product');
        $this->renameTable('shop_product_attribute', 'shop__product_attribute');
        $this->renameTable('shop_product_attribute_measure', 'shop__product_attribute_measure');
        $this->renameTable('shop_product_attribute_measure_option', 'shop__product_attribute_measure_option');
        $this->renameTable('shop_product_attribute_set', 'shop__product_attribute_set');
        $this->renameTable('shop_product_attribute_set_map', 'shop__product_attribute_set_map');
        $this->renameTable('shop_product_attribute_value', 'shop__product_attribute_value');
        $this->renameTable('shop_product_attribute_value_map', 'shop__product_attribute_value_map');
        $this->renameTable('shop_product_brand', 'shop__product_brand');
        $this->renameTable('shop_product_eav', 'shop__product_eav');
        $this->renameTable('shop_product_eav_text', 'shop__product_eav_text');
        $this->renameTable('shop_product_image', 'shop__product_image');
        $this->renameTable('shop_product_link', 'shop__product_link');
        $this->renameTable('shop_product_price', 'shop__product_price');
        $this->renameTable('shop_product_pricelist', 'shop__product_pricelist');
        $this->renameTable('shop_product_pricelist_set_map', 'shop__product_pricelist_set_map');
        $this->renameTable('shop_product_set', 'shop__product_set');
        $this->renameTable('shop_product_set_map', 'shop__product_set_map');
        $this->renameTable('shop_product_type', 'shop__product_type');
        $this->renameTable('shop_product_video', 'shop__product_video');
        $this->renameTable('shop_vaucher', 'shop__vaucher');
        $this->renameTable('shop_vaucher_use', 'shop__vaucher_use');
	}

	public function down()
	{
		echo "m120416_123301_rename_shop does not support migration down.\n";
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