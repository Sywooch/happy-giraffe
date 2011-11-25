<?php

class m111030_105143_billing extends CDbMigration
{
	public function up()
	{
		$this->execute("
		DROP TABLE IF EXISTS `billing_system`;
		");
		sleep(1);
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
		) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
		");
		sleep(1);
		$this->execute("
		DELETE FROM `billing_system`;
		");
		
		sleep(1);
		$this->execute("
		INSERT INTO `billing_system` (`system_id`, `system_code`, `system_title`, `system_icon_file`, `system_params`, `system_prepaid`, `system_status`) VALUES
			(1, 'WM', 'WebMoney', '', 'purse=R335807484635\r\nsecret_key=IG1lTZXs11pMkVvZTQ0n\r\n', 1, 1),
			(2, 'YM', 'YandexMoney', '', 'client_id=76936EC0C9E645B3F54F03F5DBE61D4ADE4BA8A2F97DB24A684F18B42CCD076B\r\n', 1, 0),
			(3, 'COURIER', 'Оплата курьером', '', '', 0, 1),
			(4, 'BANK', 'BankWire', '', '', 1, 1),
			(5, 'QIWI', 'QIWI кошелёк', '', 'shopID=19025\r\npassword=SaLhhd1cIcpPUBI978or\r\n', 1, 1);
		");
		sleep(1);
		
		$this->execute("
		DROP TABLE IF EXISTS `billing_system_BANK_requisite`;
		");
		sleep(1);
		$this->execute("
		CREATE TABLE IF NOT EXISTS `billing_system_BANK_requisite` (
		  `requisite_id` int(10) NOT NULL auto_increment,
		  `requisite_name` varchar(150) default NULL,
		  `requisite_account` varchar(150) default NULL,
		  `requisite_bank` varchar(150) default NULL,
		  `requisite_bank_address` varchar(150) default NULL,
		  `requisite_bik` varchar(150) default NULL,
		  `requisite_cor_account` varchar(150) default NULL,
		  `requisite_inn` varchar(150) default NULL,
		  `requisite_kpp` varchar(150) default NULL,
		  PRIMARY KEY  (`requisite_id`)
		);
		");
		sleep(1);
		$this->execute("
		DROP TABLE IF EXISTS `billing_system_payment_form_QIWI`;
		");
		sleep(1);
		$this->execute("
		CREATE TABLE IF NOT EXISTS `billing_system_payment_form_QIWI` (
		  `form_id` int(10) unsigned NOT NULL auto_increment,
		  `form_time` int(10) unsigned default '0',
		  `form_payment_id` int(10) unsigned NOT NULL,
		  `form_gsm` varchar(16) NOT NULL,
		  PRIMARY KEY  (`form_id`)
		) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
		");
		sleep(1);
		$this->execute("
		DELETE FROM `billing_system_payment_form_QIWI`;
		");

	}

	public function down()
	{
		echo "m111030_105143_billing does not support migration down.\n";
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