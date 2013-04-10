<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 4/10/13
 * Time: 12:11 PM
 * To change this template use File | Settings | File Templates.
 */
class UserController extends MController
{
    public function actionIndex($user_id, $show = null)
    {
        $user = User::model()->findByPk($user_id);

        $scopes = array('active', 'full');
        if ($show !== null)
            $scopes[] = $show;
        $dp = new CActiveDataProvider('CommunityContent', array(
            'criteria' => array(
                'order' => 't.created DESC',
                'scopes' => array('active', 'full'),
                'condition' => 'author_id = :user_id',
                'params' => array(':user_id' => $user_id),
            ),
            'pagination' => array(
                'pageSize' => 3,
            ),
        ));

        $this->pageTitle = $user->fullName . ' на Веселом Жирафе';
        $this->render('index', compact('user', 'dp'));
    }
}
