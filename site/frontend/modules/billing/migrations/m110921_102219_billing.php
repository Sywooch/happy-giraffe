<?php

class m110921_102219_billing extends CDbMigration
{
	public function up()
	{
		$this->execute("
			CREATE TABLE `billing_system` (
			`system_id` INT(10) NOT NULL DEFAULT '0',
			`system_code` VARCHAR(16) NOT NULL,
			`system_title` VARCHAR(64) NOT NULL,
			`system_icon_file` VARCHAR(250) NOT NULL,
			`system_params` TEXT NOT NULL,
			`system_status` TINYINT(1) NOT NULL DEFAULT '0',
			PRIMARY KEY (`system_id`),
			UNIQUE INDEX `system_code` (`system_code`)
			)
		");
		$this->execute("
			CREATE TABLE `billing_invoice` (
			`invoice_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
			`invoice_order_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
			`invoice_time` INT(10) UNSIGNED NOT NULL DEFAULT '0',
			`invoice_amount` DECIMAL(12,2) UNSIGNED NOT NULL DEFAULT '0.00',
			`invoice_currency` CHAR(3) NOT NULL,
			`invoice_description` VARCHAR(250) NOT NULL,
			`invoice_payer_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
			`invoice_payer_name` VARCHAR(64) NOT NULL,
			`invoice_payer_email` VARCHAR(128) NOT NULL,
			`invoice_payer_gsm` VARCHAR(16) NOT NULL,
			`invoice_status` TINYINT(4) NOT NULL DEFAULT '0',
			`invoice_status_time` INT(10) UNSIGNED NOT NULL DEFAULT '0',
			`invoice_paid_amount` DECIMAL(12,2) UNSIGNED NULL DEFAULT NULL,
			`invoice_paid_time` INT(10) UNSIGNED NULL DEFAULT NULL,
			PRIMARY KEY (`invoice_id`)
			)
		");
		$this->execute("
			CREATE TABLE `billing_invoice_payment` (
			`payment_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
			`payment_system_id` INT(10) UNSIGNED NOT NULL,
			`payment_invoice_id` INT(10) UNSIGNED NOT NULL,
			`payment_time` INT(10) UNSIGNED NOT NULL,
			`payment_amount` DECIMAL(12,2) UNSIGNED NOT NULL,
			`payment_currency` CHAR(3) NOT NULL,
			`payment_description` VARCHAR(255) NOT NULL,
			`payment_accept_time` INT(10) UNSIGNED NOT NULL,
			`payment_accept_info` VARCHAR(255) NOT NULL,
			`payment_notice_time` INT(10) UNSIGNED NOT NULL,
			`payment_notice_info` VARCHAR(255) NOT NULL,
			`payment_result_time` INT(10) UNSIGNED NOT NULL,
			`payment_result_info` VARCHAR(255) NOT NULL,
			`payment_status` TINYINT(1) NOT NULL DEFAULT '0',
			`payment_status_time` INT(10) UNSIGNED NOT NULL,
			`payment_status_code` VARCHAR(16) NOT NULL DEFAULT '0',
			`payment_status_reason` VARCHAR(255) NULL DEFAULT NULL,
			`payment_status_admin_id` INT(10) UNSIGNED NOT NULL,
			PRIMARY KEY (`payment_id`)
			)
		");
	}

	public function down()
	{
		echo "m110921_102219_billing does not support migration down.\n";
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