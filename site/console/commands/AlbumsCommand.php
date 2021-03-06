<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 11/9/12
 * Time: 9:27 AM
 * To change this template use File | Settings | File Templates.
 */
class AlbumsCommand extends CConsoleCommand
{
    public function actionFixPhoto($id)
    {
        $photo = AlbumPhoto::model()->findByPk($id);
        $photo->getPreviewPath(210, null, Image::WIDTH, false, AlbumPhoto::CROP_SIDE_CENTER, true);
    }

    public function actionTest()
    {
        Yii::import('site.frontend.extensions.EPhpThumb.*');

        $this->getPreviewPath(300, 1000);
    }

    public function getPreviewPath($width = 100, $height = 100, $master = false)
    {
        $thumb = new EPhpThumb();
        $thumb->init(); //this is needed


        $thumb = $thumb->create('F:/mira.jpg');
        var_dump($thumb->getCurrentDimensions());
        $thumb = $thumb->resize($width, $height);
        $thumb->save('F:/mira2.jpg');
    }

    public function actionGeneratePhotoPostsViewPhotos()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.common.models.mongo.*');
        Yii::import('site.frontend.modules.gallery.components.*');
        Yii::import('site.frontend.modules.notifications.components.*');
        Yii::import('site.frontend.modules.notifications.models.base.*');
        Yii::import('site.frontend.modules.notifications.models.*');
        $criteria = new CDbCriteria();
        $criteria->order = 't.id ASC';
        $criteria->compare('t.type_id', CommunityContent::TYPE_PHOTO_POST);
        $dp = new CActiveDataProvider('CommunityContent', array('criteria' => $criteria));
        $iterator = new CDataProviderIterator($dp, 1000);
        $count = $dp->totalItemCount;
        $i = 0;
        foreach ($iterator as $photoPost) {
            $i++;
            $collection = new PhotoPostPhotoCollection(array('contentId' => $photoPost->id));
            $criteria2 = new CDbCriteria();
            $criteria2->addInCondition('t.id', $collection->photoIds);
            $photos = AlbumPhoto::model()->findAll($criteria2);
            foreach ($photos as $photo)
                $photo->generatePhotoViewPhotos();
            echo $i . '/' . $count . "\n";
        }
    }

    public function actionGenerateContestsViewPhotos()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.common.models.mongo.*');
        Yii::import('site.frontend.modules.gallery.components.*');
        Yii::import('site.frontend.modules.notifications.components.*');
        Yii::import('site.frontend.modules.notifications.models.base.*');
        Yii::import('site.frontend.modules.notifications.models.*');
        Yii::import('site.frontend.modules.contest.models.*');
        $contests = Contest::model()->with('works', 'works.photoAttach', 'works.photoAttach.photo')->findAll('t.id >= 12');
        foreach ($contests as $c) {
            foreach ($c->works as $w) {
                echo $w->id . "\n";
                $w->photoAttach->photo->generatePhotoViewPhotos();
            }
        }
    }

    public function actionGenerateAlbumsViewPhotos($id)
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.common.models.mongo.*');
        Yii::import('site.frontend.modules.gallery.components.*');
        Yii::import('site.frontend.modules.notifications.components.*');
        Yii::import('site.frontend.modules.notifications.models.base.*');
        Yii::import('site.frontend.modules.notifications.models.*');
        Yii::import('site.frontend.modules.scores.components.*');
        Yii::import('site.frontend.modules.scores.models.*');
        Yii::import('site.frontend.modules.scores.models.input.*');
        $criteria = new CDbCriteria();
        $criteria->order = 't.id DESC';
        $criteria->condition = 't.id <= :id';
        $criteria->params = array(':id' => $id);
        $dp = new CActiveDataProvider('Album', array('criteria' => $criteria));
        $iterator = new CDataProviderIterator($dp, 1000);
        $count = $dp->totalItemCount;
        $i = 0;
        foreach ($iterator as $album) {
            $i++;
            $collection = new AlbumPhotoCollection(array('albumId' => $album->id));
            $criteria2 = new CDbCriteria();
            $criteria2->addInCondition('t.id', $collection->photoIds);
            $photos = AlbumPhoto::model()->findAll($criteria2);
            foreach ($photos as $photo) {
                $photo->generatePhotoViewPhotos();
                echo $photo->id . "\n";
            }
            echo $album->id . ' - ' . $i . '/' . $count . "\n";
        }
    }

    public function actionFixWysiwygPhotosTest($id)
    {
        $post = CommunityPost::model()->findByPk($id);
        var_dump($post->forEdit->text);
    }

    public function actionFixWysiwygPhotosPosts()
    {
        $dp = new CActiveDataProvider('CommunityPost');
        $iterator = new CDataProviderIterator($dp, 1000);
        $count = $dp->totalItemCount;
        $i = 0;
        foreach ($iterator as $post) {
            $i++;
            $post->forEdit->text;
            echo $i . '/' . $count . "\n";
        }
    }

    public function actionFixWysiwygPhotosComments()
    {
        $dp = new CActiveDataProvider('Comment');
        $iterator = new CDataProviderIterator($dp, 1000);
        $count = $dp->totalItemCount;
        $i = 0;
        foreach ($iterator as $comment) {
            $i++;
            $comment->forEdit->text;
            echo $i . '/' . $count . "\n";
        }
    }
}
