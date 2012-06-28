<?php

class m120628_073218_deode_cook_decoration extends CDbMigration
{
	public function up()
	{
        Yii::import('site.frontend.modules.cook.models.*');
        foreach(CookDecoration::model()->findAll() as $model)
        {
            $model->description = CHtml::decode($model->description);
            $model->save();
        }
	}

	public function down()
	{
		echo "m120628_073218_deode_cook_decoration does not support migration down.\n";
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