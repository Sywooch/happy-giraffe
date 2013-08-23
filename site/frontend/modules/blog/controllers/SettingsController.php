<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 6/26/13
 * Time: 1:26 PM
 * To change this template use File | Settings | File Templates.
 */

class SettingsController extends HController
{
    public function actionForm()
    {
        $this->renderPartial('form');
    }

    public function actionUpdate()
    {
        $blogTitle = Yii::app()->request->getPost('blog_title');
        $blogDescription = Yii::app()->request->getPost('blog_description');
        $blogPhotoPosition = Yii::app()->request->getPost('blog_photo_position');
        $blogPhotoId = CJSON::decode(Yii::app()->request->getPost('blog_photo_id'));
        $blogShowRubrics = CJSON::decode(Yii::app()->request->getPost('blog_show_rubrics'));

        $user = Yii::app()->user->model;
        $user->blog_title = $blogTitle == $user->getDefaultBlogTitle() ? null : $blogTitle;
        $user->blog_description = $blogDescription;
        $user->blog_show_rubrics = $blogShowRubrics;

        $photo = $blogPhotoId !== null ? AlbumPhoto::model()->findByPk($blogPhotoId) : AlbumPhoto::createByUrl('http://dev.happy-giraffe.ru/images/jcrop-blog.jpg', Yii::app()->user->id);
        $image = Yii::app()->phpThumb->create($photo->getOriginalPath());
        $rx = 720 / $blogPhotoPosition['w'];
        $ry = 128 / $blogPhotoPosition['h'];
        $width = round($rx * $photo->width);
        $height = round($ry * $photo->height);
        $image->resize($width, $height)->crop($rx * $blogPhotoPosition['x'], $ry * $blogPhotoPosition['y'], $rx * $blogPhotoPosition['w'], $ry * $blogPhotoPosition['h'])->save($photo->getBlogPath());
        $user->blog_photo_id = $photo->id;
        $user->blog_photo_position = CJSON::encode($blogPhotoPosition);

        $success = $user->save(true, array('blog_title', 'blog_description', 'blog_photo_id', 'blog_photo_position', 'blog_show_rubrics'));
        $response = compact('success');
        if ($success)
            $response['thumbSrc'] = $photo->getBlogUrl();
        echo CJSON::encode($response);
    }

    public function actionRubricEdit()
    {
        $id = Yii::app()->request->getPost('id');
        $title = Yii::app()->request->getPost('title');
        $rubric = CommunityRubric::model()->findByPk($id);
        $rubric->title = $title;
        $success = $rubric->save(true, array('title'));
        $response = compact('success');
        echo CJSON::encode($response);
    }

    public function actionRubricRemove()
    {
        $id = Yii::app()->request->getPost('id');
        $success = CommunityRubric::model()->deleteByPk($id) > 0;
        $response = compact('success');
        echo CJSON::encode($response);
    }

    public function actionRubricCreate()
    {
        $title = Yii::app()->request->getPost('title');
        $rubric = new CommunityRubric();
        $rubric->title = $title;
        $rubric->user_id = Yii::app()->user->id;
        $success = $rubric->save();
        $response = compact('success');
        if ($success)
            $response['id'] = $rubric->id;
        echo CJSON::encode($response);
    }

    public function actionUploadPhoto()
    {
        $model = AlbumPhoto::model()->createUserTempPhoto($_FILES['photo']);

        $response = array(
            'id' => $model->id,
            'originalSrc' => $model->getOriginalUrl(),
            'thumbSrc' => null,
            'width' => $model->width,
            'height' => $model->height,
            'position' => null,
        );

        $this->renderPartial('uploadPhoto', compact('response'));

    }

//    public function actionTest()
//    {
//        $position = array(
//            'h' => 100,
//            'w' => 565,
//            'x' => 63,
//            'x2' => 629,
//            'y' => 239,
//            'y2' => 339,
//        );
//
//        $image = Yii::createComponent(array(
//            'class' => 'site.frontend.extensions.EPhpThumb.EPhpThumb',
//            'options' => array(
//                'resizeUp' => true,
//            ),
//        ));
//        $image->init();
//        $image = $image->create('/home/giraffe/happy-giraffe.ru/site/frontend/www-submodule/images/jcrop-blog.jpg');
//
//        $rx = 720 / $position['w'];
//        $ry = 128 / $position['h'];
//        $width = round($rx * 730);
//        $height = round($ry * 520);
//
//        $image->resize($width, $height)->crop($rx * $position['x'], $ry * $position['y'], $rx * $position['w'], $ry * $position['h'])->show();
//    }
}