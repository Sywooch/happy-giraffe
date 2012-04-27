<?php

class m120426_113838_add_last_dialog_message_id extends CDbMigration
{
    private $_table = 'im__dialogs';

    public function up()
    {
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
                $this->update($this->_table, array('last_message_id' => $last_message_id), 'id='.$dialog_id);
        }

        $this->addForeignKey('fk_' . $this->_table . '_message', $this->_table, 'last_message_id', 'im__messages', 'id', 'CASCADE', "CASCADE");
        $this->execute('ALTER TABLE  `im__deleted_messages` ADD PRIMARY KEY (  `message_id` ,  `user_id` ) ;');
    }

    public function down()
    {
        $this->dropForeignKey('fk_' . $this->_table . '_message', $this->_table);
        $this->dropColumn($this->_table, 'last_message_id');
        $this->execute('ALTER TABLE  `im__deleted_messages` DROP PRIMARY KEY;');
    }
}