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
    public function actionConvertPost($id)
    {
        $model = CommunityPost::model()->findByAttributes(array('content_id' => $id));
        if (strpos($model->text, '<img') !== false && strpos($model->text, '<!-- widget:') === false) {
            $model->text = $this->replaceImages($model, $model->text);
            $model->save();
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

//            $parent = pq($image)->parent();
//            if (pq($parent)->length == 0) {
                pq($image)->replaceWith($this->renderFile(Yii::getPathOfAlias('site.frontend.views.albums._widget') . '.php', array(
                    'model' => $photo,
                    'title' => pq($image)->attr('title'),
                    'alt' => pq($image)->attr('alt')
                ), true));
//            } else {
//                while (pq($parent)->length > 0) {
//                    echo '1';
//                    $old_parent = $parent;
//                    $parent = pq($parent)->parent();
//                }
//                pq($parent)->append($this->renderFile(Yii::getPathOfAlias('site.frontend.views.albums._widget') . '.php', array('model' => $photo), true));
//                pq($image)->remove();
//            }
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

    public function actionConvertPhotoImagesTest()
    {
        $html = '<p>ldgjgdjfk</p>
<p><img src="http://img.happy-giraffe.ru/thumbs/700x700/114717/b3e03bdd1b67f9a5e0638ccc9adea72f.jpg" class="content-img" alt="Как избавиться от плесени на кухне фото 1" title="Как избавиться от плесени на кухне фото 1" /></p>
<p>;dkfhldsjgj.</p>';
        echo $this->replaceImages(null, $html);
    }
}

