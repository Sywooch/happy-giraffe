<?php
/**
 * Author: alexk984
 * Date: 13.03.12
 */

class ConvertNewCommand extends CConsoleCommand
{
    public function actionUpdatePhotos()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('author_id', 9990);
        $criteria->limit = 1000;
        $criteria->offset = 0;

        $models = array(0);
        while (!empty($models)) {
            $models = AlbumPhoto::model()->findAll($criteria);

            foreach ($models as $model)
                $model->save();

            $criteria->offset += 1000;
            echo $criteria->offset . "\n";
        }
    }

    /**
     * Создание фото-постов из постов с галереями
     */
    public function actionConvertPhotoImages()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->offset = 0;

        $models = array(0);
        while (!empty($models)) {
            $models = CommunityPost::model()->findAll($criteria);
            foreach ($models as $model) {
                if (empty($model->content)) {
                    $model->delete();
                } elseif (strpos($model->text, '<img') !== false && strpos($model->text, '<!-- widget:') === false) {
                    $model->text = $this->replaceImages($model, $model->text);
                    $model->save();
                }
            }

            $criteria->offset += 100;
            echo $criteria->offset . "\n";
        }
    }

    public function actionConvertPhotoTest($id)
    {
        $model = CommunityPost::model()->findByAttributes(array('content_id' => $id));
        if (strpos($model->text, '<img') !== false && strpos($model->text, '<!-- widget:') === false) {
            $model->text = $this->replaceImages($model, $model->text);
            $model->save();
        }
    }

    /**
     * @param CommunityPost $model
     * @param string $text
     * @return string
     */
    private function replaceImages($model, $text)
    {
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');

        $doc = phpQuery::newDocumentHTML($text);
        foreach ($doc->find('img') as $image) {
            $photo = AlbumPhoto::getPhotoFromUrl(pq($image)->attr('src'));
            if (empty($photo)) {
                $photo = $this->createPhoto($model, pq($image)->attr('src'));
                if (!$photo)
                    pq($image)->replaceWith('');
            } else {

                $alt = pq($image)->attr('alt');
                if (empty($photo->title) && !empty($alt) && $alt !== 'null') {
                    $photo->title = $alt;
                    $photo->update(array('title'));
                }

                pq($image)->replaceWith($this->renderFile(Yii::getPathOfAlias('site.frontend.views.albums._widget') . '.php', array(
                    'model' => $photo
                ), true));
            }
        }

        $text = $doc->html();
        $doc->unloadDocument();

        return $text;
    }

    /**
     * @param CommunityPost $model
     * @param string $src
     */
    private function createPhoto($model, $src)
    {
        if (strpos($src, '/') === 0)
            $src = 'http://www.happy-giraffe.ru' . $src;
        return AlbumPhoto::createByUrl($src, $model->content->author_id, Album::TYPE_DIALOGS);
    }

    public function actionRating()
    {
        Yii::import('site.common.models.mongo.*');
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.modules.favourites.models.*');

        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->offset = 0;

        $models = array(0);
        while (!empty($models)) {
            $models = CommunityContent::model()->findAll($criteria);
            foreach ($models as $model)
                PostRating::reCalc($model);

            $criteria->offset += 100;
            echo $criteria->offset . "\n";
        }
    }

    /**
     * Установить рубрику для постов у которых её нет
     */
    public function actionSetStatusesRubric()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 1000;
        $criteria->offset = 0;
        $criteria->condition = 'rubric_id IS NULL';

        $models = array(0);
        while (!empty($models)) {
            $models = CommunityContent::model()->resetScope()->findAll($criteria);
            foreach ($models as $model){
                if (empty($model->rubric_id))
                    $model->rubric_id = CommunityRubric::getDefaultUserRubric($model->author_id);
                if (!empty($model->rubric_id))
                    $model->update(array('rubric_id'));
                else
                    echo 1;
            }

            $criteria->offset += 1000;
            echo $criteria->offset . "\n";
        }
    }
}

