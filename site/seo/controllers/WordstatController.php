<?php
/**
 * Author: alexk984
 * Date: 29.05.12
 */
class WordstatController extends SController
{
    public $cookie = '';
    public $session = 1;

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('admin'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionAddKeywords()
    {
        $keyword = Yii::app()->request->getPost('keyword');

        $allSearch = Yii::app()->search
            ->select('*')
            ->from('keywords')
            ->where(' ' . $keyword . ' ')
            ->limit(0, 50000)
            ->searchRaw();
        $count = 0;
        foreach ($allSearch['matches'] as $key => $m)
            if (ParsingKeywords::model()->addKeywordById($key))
                $count++;

        echo CJSON::encode(array(
            'status' => true,
            'count' => $count
        ));
    }

    public function actionAddCompetitors()
    {
        $keywords = Yii::app()->db_seo->createCommand('select keyword_id from baby_stats__key_stats')->queryColumn();
        $count = 0;
        foreach ($keywords as $keyword)
            if (ParsingKeywords::model()->addKeywordById($keyword['keyword_id']))
                $count++;

        echo CJSON::encode(array(
            'status' => true,
            'count' => $count
        ));
    }
}
