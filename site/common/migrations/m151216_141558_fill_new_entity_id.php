<?php

class m151216_141558_fill_new_entity_id extends CDbMigration
{
	public function up()
	{
		/*first variant*/
		/*$iterator = new \CDataProviderIterator(new \CActiveDataProvider(\Comment::model(), array(
			'pagination' => array(
				'pageSize' => 100,
			),
		)));

		$counter = 0;
		foreach ($iterator as $model) {
			echo $counter;

			$entity = $model->entity;
			$entity_id = $model->entity_id;

			if ($entity != 'BlogContent') {
				$content = \site\frontend\modules\posts\models\Content::model()->find(array(
					'select' => 'id',
					'condition' => "originEntity = '" . $entity . "' and originEntityId = " . $entity_id));
			} else {
				$content = \site\frontend\modules\posts\models\Content::model()->find(array(
					'select' => 'id',
					'condition' => "originService = 'oldBlog' and originEntityId = " . $entity_id));
			}

			if ($content != null) {
				$model->new_entity_id = $content->id;

				$model->save();
			} else {
				echo " null content";
			}

			echo "\n";

			$counter++;
		}*/

		/*second variant*/
		$iterator = new \CDataProviderIterator(new \CActiveDataProvider(\site\frontend\modules\posts\models\Content::model(), array(
			'criteria' => array(
				'select' => 'id, originService, originEntity, originEntityId',
			),
			'pagination' => array(
				'pageSize' => 100,
			),
		)));

		$counter = 0;
		foreach ($iterator as $model) {
			echo $counter;

			$comments = \Comment::model()->findAll(array(
				//'select' => 'id',
				'condition' => "entity = '" . ($model->originService == "oldBlog" ? "BlogContent" : $model->originEntity) . "' and entity_id = " . $model->originEntityId));

			if (count($comments) > 0) {
				$ids = array();
				foreach ($comments as $comment) {
					array_push($ids, $comment->id);
				}

				$ids = join(",", $ids);

				$this->execute("UPDATE `comments` SET `comments`.`new_entity_id`=" . $model->id . " WHERE `comments`. `id` IN (" . $ids . ");");
			}

			$counter++;
			echo "\n";
		}
	}

	public function down()
	{
		echo "Nothing done but return true.";
		return true;
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