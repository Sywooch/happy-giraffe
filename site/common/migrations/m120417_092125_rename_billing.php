<?php

class m120417_092125_rename_billing extends CDbMigration
{
	public function up()
	{
        $this->renameTable('billing_invoice','billing__invoices');
        $this->renameTable('billing_invoice_payment','billing__invoice_payments');
        $this->renameTable('billing_system','billing__systems');
        $this->renameTable('billing_system_BANK_requisite','billing__system_BANK_requisites');
        $this->renameTable('billing_system_payment_form_QIWI','billing__system_payment_form_QIWI');
	}

	public function down()
	{
		echo "m120417_092125_rename_billing does not support migration down.\n";
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