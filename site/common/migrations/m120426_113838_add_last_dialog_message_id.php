<?php

class m120426_113838_add_last_dialog_message_id extends CDbMigration
{
    private $_table = 'im__dialogs';

    public function up()
    {
        $columns = Yii::app()->db->createCommand('SHOW COLUMNS FROM ' . $this->_table)->queryColumn();
        if (count($columns) < 3) {
            $this->addColumn($this->_table, 'last_message_id', 'int(10) UNSIGNED');

            $dialog_ids = Yii::app()->db->createCommand('SELECT id FROM im__dialogs')->queryColumn();
            foreach ($dialog_ids as $dialog_id) {
                $last_message_id = Yii::app()->db->createCommand()
                    ->select('id')
                    ->from('im__messages')
                    ->where('dialog_id=:dialog_id', array(':dialog_id' => $dialog_id))
                    ->limit(1)
                    ->order('id desc')
                    ->queryScalar();

                if ($last_message_id != null)
                    $this->update($this->_table, array('last_message_id' => $last_message_id), 'id=' . $dialog_id);
            }
            $this->addForeignKey('fk_' . $this->_table . '_message', $this->_table, 'last_message_id', 'im__messages', 'id', 'CASCADE', "CASCADE");
        }

        $this->_table = 'im__deleted_messages';
        $columns = Yii::app()->db->createCommand('SHOW COLUMNS FROM ' . $this->_table)->queryColumn();
        if (count($columns) > 2) {
            foreach ($columns as $column) {
                if ($column != 'message_id' && $column != 'user_id') {
                    if ($column == 'dialog_id') {
                        $fk = 'SELECT `CONSTRAINT_NAME`
                        FROM `information_schema`.`REFERENTIAL_CONSTRAINTS`
                      WHERE `TABLE_NAME` = "im__deleted_messages" AND `REFERENCED_TABLE_NAME` = "im__dialogs" AND CONSTRAINT_SCHEMA = "happy_giraffe"';
                        $fk = Yii::app()->db->createCommand($fk)->queryScalar();
                        if (!empty($fk))
                            $this->dropForeignKey($fk, 'users');
                    }
                    $this->dropColumn($this->_table, $column);
                }
            }
        }
        $this->execute('ALTER TABLE  `im__deleted_messages` ADD PRIMARY KEY (  `message_id` ,  `user_id` ) ;');
    }

    public function down()
    {
//        $this->dropForeignKey('fk_' . $this->_table . '_message', $this->_table);
//        $this->dropColumn($this->_table, 'last_message_id');
//        $this->execute('ALTER TABLE  `im__deleted_messages` DROP PRIMARY KEY;');
    }
}