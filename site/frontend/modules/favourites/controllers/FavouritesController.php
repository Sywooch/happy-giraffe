<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 5/17/13
 * Time: 10:28 AM
 * To change this template use File | Settings | File Templates.
 */
class FavouritesController extends HController
{
    public function actionAdd()
    {
        $tagsNames = Yii::app()->request->getPost('tagsNames');

        $tags = $this->processTags($tagsNames);
        $favourite = new Favourite();
        $favourite->attributes = $_POST['Favourite'];
        $favourite->user_id = Yii::app()->user->id;
        $favourite->tags = $tags;
        $success = $favourite->withRelated->save(true, array('tags'));

        $response = compact('success');
        echo CJSON::encode($response);
    }

    public function actionUpdateTags()
    {
        $favouriteId = Yii::app()->request->getPost('favouriteId');
        $tagsNames = Yii::app()->request->getPost('tagsNames');

        $favourite = Favourite::model()->findByPk($favouriteId);
        if ($favourite === null)
            throw new CHttpException(400);

        $tags = $this->processTags($tagsNames);
        $favourite->tags = $tags;
        Yii::app()->db->createCommand()->delete('favourites__tags_favourites', 'favourite_id = :favourite_id', array(':favourite_id' => $favouriteId));
        $success = $favourite->withRelated->save(true, array('tags'));

        $response = compact('success');
        echo CJSON::encode($response);
    }

    public function actionRemove()
    {
        $favouriteId = Yii::app()->request->getPost('favouriteId');
        $success = Favourite::model()->deleteByPk($favouriteId) > 0;

        $response = compact('success');
        echo CJSON::encode($response);
    }

    protected function processTags($tagsNames)
    {
        return array_map(function($name) {
            $tag = FavouriteTag::model()->findByAttributes(array('name' => $name));
            if ($tag === null) {
                $tag = new FavouriteTag();
                $tag->name = $name;
                $tag->save();
            }
            return $tag;
        }, explode(',', $tagsNames));
    }
}
