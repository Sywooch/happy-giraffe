<?php

class m131213_101748_messaging_v2 extends CDbMigration
{

	public function up()
	{
		// добавляем два поля с датой прочтения и датой удаления
		$this->execute('ALTER TABLE `messaging__messages_users` ADD COLUMN `dtime_read` TIMESTAMP NULL DEFAULT NULL  AFTER `deleted` , ADD COLUMN `dtime_delete` TIMESTAMP NULL DEFAULT NULL  AFTER `dtime_read`;');
		// переписываем значения из старых полей в новые
		$this->execute('
UPDATE `messaging__messages_users` mmu
 LEFT JOIN `messaging__messages` mm
 ON mmu.`message_id` = mm.`id`
 SET
  mmu.`dtime_read` = if(mmu.`read`, mm.`created`, NULL),
  mmu.`dtime_delete` = if(mmu.deleted, mm.`created`, NULL);
');
		// удаляем старые поля
		$this->execute('ALTER TABLE `messaging__messages_users` DROP COLUMN `deleted` , DROP COLUMN `read`;');
	}

	public function down()
	{
		echo "m131213_101748_messaging_v2 does not support migration down.\n";
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