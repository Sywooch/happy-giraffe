<?php

namespace site\frontend\modules\iframe\modules\userProfile\controllers;

use site\frontend\modules\users\models\User;

/**
 * @author Никита
 * @date 25/12/14
 */
class DefaultController extends \LiteController
{

    public $litePackage = 'member';

    public function getListDataProvider($authorId)
    {
        $criteria = \site\frontend\modules\posts\models\Content::model()->byService('oldBlog')->byAuthor($authorId)->orderDesc()->getDbCriteria();
        return new \CActiveDataProvider('\site\frontend\modules\posts\models\Content', array(
            'criteria' => clone $criteria,
            'pagination' => array(
                'pageSize' => 10,
                'pageVar' => 'page',
            )
        ));
    }

    /**
     * @param $userId
     * @throws \CHttpException
     * @sitemap dataSource=sitemapView
     */
    public function actionIndex($userId, $page = 1)
    {
        $user = User::model()->active()->findByPk($userId);
        if ($user === null) {
            header("HTTP/1.0 404 Not Found");
            $this->render('deleted');
        } else {
            \NoindexHelper::setNoIndex($user);
            $this->render('index', array('user' => $user));
        }
    }

    public function sitemapView()
    {
        $models = \Yii::app()->db->createCommand()
            ->select('u.id, c.updated, c.created')
            ->from('users u')
            ->join('community__contents c', 'c.author_id = u.id')
            ->where('u.deleted = 0 AND u.id != ' . \User::HAPPY_GIRAFFE . ' AND c.removed = 0 AND (c.uniqueness >= 50 OR c.uniqueness IS NULL) AND c.type_id != 5')
            ->order('u.id ASC')
            ->group('u.id')
            ->queryAll();

        $data = array();
        foreach ($models as $model)
        {
            $data[] = array(
                'params' => array(
                    'userId' => $model['id'],
                ),
                'changefreq' => 'daily',
                'lastmod' => ($model['updated'] === null) ? $model['created'] : $model['updated'],
            );
        }

        return $data;
    }
}
