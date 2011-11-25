<?php

class m110921_102219_billing extends CDbMigration
{
	public function up()
	{
		$this->execute("
CREATE TABLE IF NOT EXISTS `billing_invoice` (
  `invoice_id` int(10) unsigned NOT NULL auto_increment,
  `invoice_order_id` int(10) unsigned NOT NULL default '0',
  `invoice_order_proceed_time` int(10) unsigned default NULL,
  `invoice_order_paid_time` int(10) unsigned default NULL,
  `invoice_time` int(10) unsigned NOT NULL default '0',
  `invoice_amount` decimal(12,2) unsigned NOT NULL default '0.00',
  `invoice_currency` char(3) NOT NULL,
  `invoice_description` varchar(250) NOT NULL,
  `invoice_payer_id` int(10) unsigned NOT NULL default '0',
  `invoice_payer_name` varchar(64) NOT NULL,
  `invoice_payer_email` varchar(128) NOT NULL,
  `invoice_payer_gsm` varchar(16) NOT NULL,
  `invoice_status` tinyint(4) NOT NULL default '0',
  `invoice_status_time` int(10) unsigned NOT NULL default '0',
  `invoice_paid_amount` decimal(12,2) unsigned default NULL,
  `invoice_paid_time` int(10) unsigned default NULL,
  PRIMARY KEY  (`invoice_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		");

		$this->execute("
CREATE TABLE IF NOT EXISTS `billing_invoice_payment` (
  `payment_id` int(10) unsigned NOT NULL auto_increment,
  `payment_system_id` int(10) unsigned NOT NULL,
  `payment_invoice_id` int(10) unsigned NOT NULL,
  `payment_time` int(10) unsigned NOT NULL,
  `payment_amount` decimal(12,2) unsigned NOT NULL,
  `payment_currency` char(3) NOT NULL,
  `payment_description` varchar(255) NOT NULL,
  `payment_accept_time` int(10) unsigned NOT NULL,
  `payment_accept_info` mediumtext NOT NULL,
  `payment_success_time` int(10) unsigned NOT NULL,
  `payment_success_info` mediumtext NOT NULL,
  `payment_fail_time` int(10) unsigned NOT NULL,
  `payment_fail_info` mediumtext NOT NULL,
  `payment_result_time` int(10) unsigned NOT NULL,
  `payment_result_info` mediumtext NOT NULL,
  `payment_status` tinyint(1) NOT NULL default '0',
  `payment_status_time` int(10) unsigned NOT NULL,
  `payment_status_code` varchar(16) NOT NULL default '0',
  `payment_status_reason` varchar(255) default NULL,
  `payment_status_admin_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`payment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		");

		$this->execute("
CREATE TABLE IF NOT EXISTS `billing_system` (
  `system_id` int(10) NOT NULL auto_increment,
  `system_code` varchar(16) NOT NULL,
  `system_title` varchar(64) NOT NULL,
  `system_icon_file` varchar(250) NOT NULL,
  `system_params` text NOT NULL,
  `system_prepaid` tinyint(1) unsigned NOT NULL default '1',
  `system_status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`system_id`),
  UNIQUE KEY `system_code` (`system_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		");

		$this->execute("
CREATE TABLE IF NOT EXISTS `billing_system_BANK_requisite` (
  `requisite_id` int(10) NOT NULL auto_increment,
  `requisite_name` varchar(50) default NULL,
  `requisite_account` varchar(50) default NULL,
  PRIMARY KEY  (`requisite_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		");

		$this->execute("
INSERT INTO `billing_system_BANK_requisite` (`requisite_id`, `requisite_name`, `requisite_account`) VALUES
	(1, 'AlfaBank', '1234567890'),
	(2, 'PrivatBank', '0987654321');
		");

		$this->execute("
INSERT INTO `billing_system` (`system_id`, `system_code`, `system_title`, `system_icon_file`, `system_params`, `system_prepaid`, `system_status`) VALUES
	(1, 'WM', 'WebMoney', '', 'purse=R335807484635\r\nsecret_key=IG1lTZXs11pMkVvZTQ0n\r\n', 1, 1),
	(2, 'YM', 'YandexMoney', '', 'client_id=76936EC0C9E645B3F54F03F5DBE61D4ADE4BA8A2F97DB24A684F18B42CCD076B\r\n', 1, 0),
	(3, 'COURIER', 'Courier', '', '', 0, 1),
	(4, 'BANK', 'BankWire', '', '', 1, 1);
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