<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 10/23/12
 * Time: 7:07 PM
 * To change this template use File | Settings | File Templates.
 */
class FeaturesController extends HController
{
    public function actionSelect()
    {
        if (Yii::app()->request->isPostRequest) {
            $key = Yii::app()->request->getPost('key');
            $val = Yii::app()->request->getPost('val');

            echo CJavaScript::encode(UserAttributes::set(Yii::app()->user->id, $key, $val));
        }
    }
}
