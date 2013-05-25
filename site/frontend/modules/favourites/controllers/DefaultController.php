
<?php

class DefaultController extends HController
{
    const QUERY_RESPONSE_TYPE_TAG = 0;
    const QUERY_RESPONSE_TYPE_KEYWORD = 1;

    public function actionIndex($entity = null, $tagId = null)
    {
        $totalCount = FavouritesManager::getCountByUserId(Yii::app()->user->id);
        $menu = array_map(function($config, $entity) {
            return array(
                'entity' => $entity,
                'title' => $config['title'],
                'count' => FavouritesManager::getCountByUserId(Yii::app()->user->id, $entity),
            );
        }, $this->module->entities, array_keys($this->module->entities));

        $data = compact('menu', 'totalCount');
        $this->render('index', compact('data'));
    }

    public function actionGet($entity = null, $tagId = null, $query = null)
    {
        $dp = FavouritesManager::getByUserId(Yii::app()->user->id, $entity, $tagId, $query);

        $this->render('get', compact('dp'));
    }

    public function actionSearch($query)
    {
        $tag = TagsManager::searchTag(Yii::app()->user->id, $query);
        if ($tag !== false) {
            $response = array(
                'tagId' => $tag['id'],
                'filter' => array(
                    'type' => self::QUERY_RESPONSE_TYPE_TAG,
                    'value' => $tag['name'],
                    'count' => $tag['c'],
                ),
            );
        } else {
            $response = array(
                'keyword' => $query,
                'filter' => array(
                    'type' => self::QUERY_RESPONSE_TYPE_KEYWORD,
                    'value' => $query,
                    'count' => Favourite::model()->count('user_id = :user_id', array(':user_id' => Yii::app()->user->id)),
                ),
            );
        }

        echo CJSON::encode($response);
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

    public function actionGetEntityData($entity, $entity_id)
    {
        $model = CActiveRecord::model($entity)->full()->findByPk($entity_id);
        if ($model === null)
            throw new CHttpException(400);

        $image = $model->getContentImage(60);
        $title = $model->title;
        $tags = array('хуй', 'пизда', 'джигурда');

        $response = compact('image', 'title', 'tags');
        echo CJSON::encode($response);
    }
}