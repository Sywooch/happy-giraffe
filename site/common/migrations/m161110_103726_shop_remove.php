<?php

class m161110_103726_shop_remove extends CDbMigration
{
	public function up()
	{
		$this->execute("SET FOREIGN_KEY_CHECKS=0;");
		$this->execute("DROP TABLE shop__category;");
		$this->execute("DROP TABLE shop__category_attribute_set_map;");
		$this->execute("DROP TABLE shop__category_attributes_map;");
		$this->execute("DROP TABLE shop__delivery;");
		$this->execute("DROP TABLE shop__delivery_cities;");
		$this->execute("DROP TABLE shop__delivery_edpd;");
		$this->execute("DROP TABLE shop__delivery_edpd_tarif;");
		$this->execute("DROP TABLE shop__delivery_edpd_tarifzone;");
		$this->execute("DROP TABLE shop__delivery_edpm;");
		$this->execute("DROP TABLE shop__delivery_edpm_tarif;");
		$this->execute("DROP TABLE shop__delivery_edzpm;");
		$this->execute("DROP TABLE shop__delivery_edzpm_city_zone_link;");
		$this->execute("DROP TABLE shop__delivery_edzpm_zone;");
		$this->execute("DROP TABLE shop__delivery_egruzovozoff;");
		$this->execute("DROP TABLE shop__delivery_egruzovozofftarif;");
		$this->execute("DROP TABLE shop__delivery_epickpoint;");
		$this->execute("DROP TABLE shop__delivery_epickpointtarif;");
		$this->execute("DROP TABLE shop__delivery_regions;");
		$this->execute("DROP TABLE shop__order;");
		$this->execute("DROP TABLE shop__order_adress;");
		$this->execute("DROP TABLE shop__order_item;");
		$this->execute("DROP TABLE shop__order_save;");
		$this->execute("DROP TABLE shop__order_save_item;");
		$this->execute("DROP TABLE shop__presents;");
		$this->execute("DROP TABLE shop__product;");
		$this->execute("DROP TABLE shop__product_attribute;");
		$this->execute("DROP TABLE shop__product_attribute_measure;");
		$this->execute("DROP TABLE shop__product_attribute_measure_option;");
		$this->execute("DROP TABLE shop__product_attribute_set;");
		$this->execute("DROP TABLE shop__product_attribute_set_map;");
		$this->execute("DROP TABLE shop__product_attribute_value;");
		$this->execute("DROP TABLE shop__product_attribute_value_map;");
		$this->execute("DROP TABLE shop__product_brand;");
		$this->execute("DROP TABLE shop__product_eav;");
		$this->execute("DROP TABLE shop__product_eav_text;");
		$this->execute("DROP TABLE shop__product_eav_text_values;");
		$this->execute("DROP TABLE shop__product_images;");
		$this->execute("DROP TABLE shop__product_items;");
		$this->execute("DROP TABLE shop__product_link;");
		$this->execute("DROP TABLE shop__product_price;");
		$this->execute("DROP TABLE shop__product_pricelist;");
		$this->execute("DROP TABLE shop__product_pricelist_set_map;");
		$this->execute("DROP TABLE shop__product_set;");
		$this->execute("DROP TABLE shop__product_set_map;");
		$this->execute("DROP TABLE shop__product_type;");
		$this->execute("DROP TABLE shop__product_video;");
		$this->execute("DROP TABLE shop__vaucher;");
		$this->execute("DROP TABLE shop__vaucher_use;");
		$this->execute("SET FOREIGN_KEY_CHECKS=1;");
	}

	public function down()
	{
		echo "m161110_103726_shop_remove does not support migration down.\n";
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