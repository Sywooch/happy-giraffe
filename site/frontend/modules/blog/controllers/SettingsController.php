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
        $this->renderPartial('settings');
    }

    public function actionUpdate()
    {
        $user = Yii::app()->user->model;
        $user->blog_title = Yii::app()->request->getPost('blog_title');
        $user->blog_description = Yii::app()->request->getPost('blog_description');
        $user->blog_photo_id = Yii::app()->request->getPost('blog_photo_id');
        $p = Yii::app()->request->getPost('blog_photo_position');
        $user->blog_photo_position = CJSON::encode($p);

        $photo = ! empty($user->blog_photo_id) ? AlbumPhoto::model()->findByPk($user->blog_photo_id) : AlbumPhoto::createByUrl('http://109.87.248.203/images/jcrop-blog.jpg', Yii::app()->user->id);

        $image = Yii::app()->phpThumb->create($photo->getOriginalPath());
        $rx = 720 / $p['w'];
        $ry = 128 / $p['h'];
        $width = round($rx * $photo->width);
        $height = round($ry * $photo->height);
        $image->resize($width, $height)->crop($rx * $p['x'], $ry * $p['y'], $rx * $p['w'], $ry * $p['h'])->save($photo->getBlogPath());
        $success = $user->save(true, array('blog_title', 'blog_description', 'blog_photo_id', 'blog_photo_position'));
        $response = compact('success');
        if ($success)
            $response['thumbSrc'] = $photo->getBlogUrl() . '?' . time();
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
        $file = CUploadedFile::getInstanceByName('photo');
        $model = new AlbumPhoto();
        $model->author_id = Yii::app()->user->id;
        $model->file = $file;
        $model->create();

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