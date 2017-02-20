<?php

class m161111_075540_shop_remove2 extends CDbMigration
{
	public function up()
	{
		$this->execute("SET FOREIGN_KEY_CHECKS=0;");
		$this->execute("DROP TABLE billing__invoice_payments;");
		$this->execute("DROP TABLE billing__invoices;");
		$this->execute("DROP TABLE billing__system_BANK_requisites;");
		$this->execute("DROP TABLE billing__system_payment_form_QIWI;");
		$this->execute("DROP TABLE billing__systems;");
		$this->execute("SET FOREIGN_KEY_CHECKS=1;");
	}

	public function down()
	{
		echo "m161111_075540_shop_remove2 does not support migration down.\n";
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