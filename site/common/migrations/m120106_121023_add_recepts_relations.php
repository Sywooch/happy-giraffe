<?php

class m120106_121023_add_recepts_relations extends CDbMigration
{
    private $_table = 'recipeBook_disease';
	public function up()
	{
        $this->addForeignKey($this->_table.'_category_fk', $this->_table, 'category_id', 'recipeBook_disease_category', 'id','CASCADE',"CASCADE");

        $this->_table = 'recipeBook_ingredient';
        $this->addForeignKey($this->_table.'_recipe_fk', $this->_table, 'recipe_id', 'recipeBook_recipe', 'id','CASCADE',"CASCADE");

        $this->_table = 'recipeBook_recipe';
        $this->addForeignKey($this->_table.'_disease_fk', $this->_table, 'disease_id', 'recipeBook_disease', 'id','CASCADE',"CASCADE");

        $this->_table = 'recipeBook_recipe_via_purpose';
        $this->addForeignKey($this->_table.'_recipe_fk', $this->_table, 'recipe_id', 'recipeBook_recipe', 'id','CASCADE',"CASCADE");
        $this->addForeignKey($this->_table.'_purpose_fk', $this->_table, 'purpose_id', 'recipeBook_recipe', 'id','CASCADE',"CASCADE");
	}

	public function down()
	{
        $this->_table = 'recipeBook_recipe_via_purpose';
        $this->dropForeignKey($this->_table . '_recipe_fk', $this->_table);
        $this->dropForeignKey($this->_table . '_purpose_fk', $this->_table);

        $this->_table = 'recipeBook_recipe';
        $this->dropForeignKey($this->_table . '_disease_fk', $this->_table);

        $this->_table = 'recipeBook_ingredient';
        $this->dropForeignKey($this->_table . '_recipe_fk', $this->_table);

        $this->_table = 'recipeBook_disease';
        $this->dropForeignKey($this->_table . '_category_fk', $this->_table);
	}
}