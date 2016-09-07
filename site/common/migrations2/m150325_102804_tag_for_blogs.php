<?php

class m150325_102804_tag_for_blogs extends CDbMigration
{

    public function up()
    {
        // Найдём id метки для блогов
        $labelId = $this->dbConnection->createCommand('select id from post__labels where `text` = "Блог";')->queryScalar();
        if(!$labelId) {
            // Если не нашли - добавим
            $label = new \site\frontend\modules\posts\models\Label();
            $label->text = 'Блог';
            $label->save(false);
            $labelId = $label->id;
        }
        if(!$labelId) {
            throw new Exception('Не найдена метка "Блог", и не удалось её добавить.');
        }
        // Список постов из клубов, или блогов, с уже проставленной меткой
        $okList = "select pt.contentId from post__labels pl join post__tags pt on pl.id = pt.labelId WHERE pl.text LIKE 'Форум: %' OR pl.text = 'Блог'";
        // Список постов, требуемых обновления. Сразу вытащим пары id-поста, id-метки
        $updateList = "select id, $labelId from post__contents where originService <> 'oldRecipe' AND isRemoved = 0 AND id not in ($okList)";
        // Добавим теги
        $sql = "insert into post__tags (contentId, labelId) $updateList;";
        $this->execute($sql);
    }

    public function down()
    {
        echo "m150325_102804_tag_for_blogs does not support migration down.\n";
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
