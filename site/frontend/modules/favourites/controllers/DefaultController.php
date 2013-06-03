
<?php

class DefaultController extends HController
{
    const QUERY_RESPONSE_TYPE_TAG = 0;
    const QUERY_RESPONSE_TYPE_KEYWORD = 1;

    public function filters()
    {
        return array(
            'accessControl',
            'ajaxOnly - index',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex($entity = null, $query = null)
    {
        $totalCount = (int) FavouritesManager::getCountByUserId(Yii::app()->user->id);
        $menu = array_map(function($config, $entity) {
            return array(
                'entity' => $entity,
                'title' => $config['title'],
                'count' => (int) FavouritesManager::getCountByUserId(Yii::app()->user->id, $entity),
            );
        }, $this->module->entities, array_keys($this->module->entities));

        $data = compact('menu', 'totalCount', 'entity', 'query');
        $this->pageTitle = 'Избранное';
        $this->render('index', compact('data'));
    }

    public function actionGet($entity = null, $tagId = null, $query = null, $offset = 0)
    {
        $favourites = array_map(function($favourite) {
            switch ($favourite->model_name) {
                case 'CommunityContent':
                case 'BlogContent':
                    $html = Yii::app()->controller->renderPartial('//community/_post', array(
                        'full' => false,
                        'data' => $favourite->relatedModel,
                    ), true);
                    break;
                case 'MultivarkaRecipe':
                case 'SimpleRecipe':
                case 'CookRecipe':
                    $html = Yii::app()->controller->renderPartial('cook.views.recipe._recipe', array(
                        'full' => false,
                        'data' => $favourite->relatedModel,
                    ), true);
                    break;
                case 'AlbumPhoto':
                    $html = Yii::app()->controller->renderPartial('//albums/favourites', array(
                        'model' => $favourite->relatedModel,
                    ), true);
                    break;
            }
            return array(
                'id' => $favourite->id,
                'modelName' => $favourite->model_name,
                'modelId' => $favourite->model_id,
                'html' => $html,
                'note' => $favourite->note,
                'tags' => $favourite->tagsNames,
            );
        }, FavouritesManager::getByUserId(Yii::app()->user->id, $entity, $tagId, $query, $offset));
        $last = FavouritesManager::getCountByUserId(Yii::app()->user->id, $entity, $tagId, $query) <= ($offset + FavouritesManager::FAVOURITES_PER_PAGE);

        $data = compact('favourites', 'last');
        echo CJSON::encode($data);
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
                    'count' => FavouritesManager::getCountByUserId(Yii::app()->user->id, null, null, $query),
                ),
            );
        }

        echo CJSON::encode($response);
    }

    public function actionGetEntityData($modelName, $modelId)
    {
        $entity = Favourite::model()->getEntityByModel($modelName, $modelId);

        switch ($entity) {
            case 'post':
            case 'video':
                $model = CActiveRecord::model($modelName)->full()->findByPk($modelId);
                if ($model === null)
                    throw new CHttpException(400);

                $image = $model->getContentImage(60);
                $title = $model->title;
                $tags = array();
                $note = '';
                break;
            case 'cook':
                $model = CActiveRecord::model($modelName)->findByPk($modelId);
                if ($model === null)
                    throw new CHttpException(400);

                $image = $model->mainPhoto->getPreviewUrl(60, null, Image::WIDTH);
                $title = $model->title;
                $tags = array();
                $note = '';
                break;
            case 'photo':
                $model = CActiveRecord::model($modelName)->findByPk($modelId);
                if ($model === null)
                    throw new CHttpException(400);

                $image = $model->getPreviewUrl(60, null, Image::WIDTH);
                $title = $model->title;
                $tags = array();
                $note = '';
                break;
        }

        $response = compact('image', 'title', 'tags', 'note');

        $userFavourite = Favourite::model()->findByAttributes(array(
            'model_name' => $modelName,
            'model_id' => $modelId,
            'user_id' => Yii::app()->user->id,
        ));
        if ($userFavourite !== null) {
            $response['note'] = $userFavourite->note;
            $response['tags'] = $userFavourite->tagsNames;
        }

        echo CJSON::encode($response);
    }

//    public function actionTest()
//    {
//        $tags = array();
//        for ($i = 0; $i < 10; $i++)
//            $tags[] = 'тег' . $i;
//
//        $photos = AlbumPhoto::model()->findAll(array('limit' => 10));
//        $posts = CommunityContent::model()->findAll(array('limit' => 20, 'condition' => 'type_id = 1'));
//        $videos = CommunityContent::model()->findAll(array('limit' => 20, 'condition' => 'type_id = 2'));
//        $recipes = CookRecipe::model()->findAll(array('limit' => 20));
//
//        $all = array_merge($posts, $videos, $recipes, $photos);
//        foreach ($all as $entity) {
//            $favourite = new Favourite();
//            $favourite->model_name = get_class($entity);
//            $favourite->model_id = $entity->id;
//            $favourite->user_id = Yii::app()->user->id;
//            $favourite->tagsNames = array_rand(array_flip($tags), rand(2, 3));
//            if (! $favourite->withRelated->save(true, array('tags'))) {
//                print_r($favourite->errors);
//                Yii::app()->end();
//            }
//        }
//    }
}