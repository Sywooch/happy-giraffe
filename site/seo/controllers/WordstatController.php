<?php
/**
 * Author: alexk984
 * Date: 29.05.12
 */
class WordstatController extends SController
{
    public $cookie = '';
    public $session = 1;

    public $layout = '//layouts/empty';

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

    public function actionAddCompetitors()
    {
        $keywords = Yii::app()->db_seo->createCommand('select distinct(keyword_id) from sites__keywords_visits ')->queryColumn();
        $count = 0;
        foreach ($keywords as $keyword_id) {
            if (ParsingKeyword::addKeyword($keyword_id))
                $count++;
        }

        echo CJSON::encode(array(
            'status' => true,
            'count' => $count
        ));
    }

    public function actionSearchPhrases()
    {
        $keywords = Yii::app()->db_seo->createCommand('select distinct(keyword_id) from pages_search_phrases')->queryColumn();
        $count = 0;
        foreach ($keywords as $keyword_id) {
            if (ParsingKeyword::addKeyword($keyword_id))
                $count++;
        }

        echo CJSON::encode(array(
            'status' => true,
            'count' => $count
        ));
    }

    public function actionLastKeywords()
    {
        $this->render('lastKeywords');
    }
}
