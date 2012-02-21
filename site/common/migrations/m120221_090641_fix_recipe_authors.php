<?php

class m120221_090641_fix_recipe_authors extends CDbMigration
{
    public function up()
    {
        $user_ids = Yii::app()->db->createCommand('select DISTINCT user_id from recipeBook_recipe WHERE user_id IS NOT NULL')->queryColumn();
        $exist_user_ids = array();
        foreach($user_ids as $user_id){
            $exist = Yii::app()->db->createCommand('select id from user WHERE id ='.$user_id)->queryScalar();
            if (!empty($exist))
                $exist_user_ids[] = $user_id;
        }
        print_r($exist_user_ids);

        $user_not_set = Yii::app()->db->createCommand('select * from recipeBook_recipe WHERE user_id IS NULL')->queryAll();

        if (!empty($exist_user_ids))
            foreach ($user_not_set as $row) {
                $user_id = $exist_user_ids[rand(0, count($exist_user_ids) - 1)];
                Yii::app()->db->createCommand()->update('recipeBook_recipe',
                    array('user_id' => $user_id), 'id=' . $row['id']);
            }
    }

    public function down()
    {

    }
}