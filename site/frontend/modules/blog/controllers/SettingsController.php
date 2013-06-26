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

    public function actionTest()
    {
        $position = array(
            'h' => 100,
            'w' => 565,
            'x' => 63,
            'x2' => 629,
            'y' => 239,
            'y2' => 339,
        );

        $image = Yii::createComponent(array(
            'class' => 'site.frontend.extensions.EPhpThumb.EPhpThumb',
            'options' => array(
                'resizeUp' => true,
            ),
        ));
        $image->init();
        $image = $image->create('/home/giraffe/happy-giraffe.ru/site/frontend/www-submodule/images/jcrop-blog.jpg');

        $rx = 720 / $position['w'];
        $ry = 128 / $position['h'];
        $width = round($rx * 730);
        $height = round($ry * 520);

        $image->resize($width, $height)->crop($rx * $position['x'], $ry * $position['y'], $rx * $position['w'], $ry * $position['h'])->show();
    }
}