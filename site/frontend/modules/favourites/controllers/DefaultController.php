
<?php

class DefaultController extends HController
{
    public function actionIndex($entity = null, $tagId = null)
    {
        $dp = FavouritesManager::getByUserId(Yii::app()->user->id, $entity, $tagId);

        $this->render('index', compact('dp'));
    }

    public function actionTest()
    {
        $tags = array('диалоги о животных', 'говяжее говно', 'dota2', 'убить билла', 'путин краб', 'да винчи', 'морта килл любого', 'chairman', 'здоровье', 'брюссельская капуста');

        $photos = AlbumPhoto::model()->findAll(array('limit' => 10));
        $posts = CommunityContent::model()->findAll(array('limit' => 10, 'condition' => 'type_id = 1'));
        $videos = CommunityContent::model()->findAll(array('limit' => 10, 'condition' => 'type_id = 2'));
        $recipes = CookRecipe::model()->findAll(array('limit' => 10));

        $all = array_merge($photos, $posts, $videos, $recipes);
        foreach ($all as $entity) {
            $favourite = new Favourite();
            $favourite->entity = get_class($entity);
            $favourite->entity_id = $entity->id;
            $favourite->user_id = Yii::app()->user->id;
            $favourite->tagsNames = array_rand(array_flip($tags), rand(2, 3));
            if (! $favourite->withRelated->save(true, array('tags'))) {
                print_r($favourite->errors);
                Yii::app()->end();
            }
        }
    }
}