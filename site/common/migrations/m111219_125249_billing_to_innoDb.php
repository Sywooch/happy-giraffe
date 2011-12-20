<?php

class m111219_125249_billing_to_innoDb extends CDbMigration
{
    private $_table = 'billing_invoice_payment';

    public function up()
    {
        $this->execute('ALTER TABLE  `billing_invoice` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `billing_invoice_payment` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `billing_system` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `billing_system_BANK_requisite` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `billing_system_payment_form_QIWI` ENGINE = INNODB');

        $this->alterColumn('billing_system', 'system_id', 'int UNSIGNED');
        $this->addForeignKey($this->_table . '_system_fk', $this->_table, 'payment_system_id', 'billing_system', 'system_id', 'CASCADE', "CASCADE");
        $this->execute('delete from billing_invoice_payment WHERE payment_invoice_id = 0');
        $this->addForeignKey($this->_table . '_invoice_fk', $this->_table, 'payment_invoice_id', 'billing_invoice', 'invoice_id', 'CASCADE', "CASCADE");
    }

    public function down()
    {
    }

}