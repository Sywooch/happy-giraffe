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

    public function actionWordstatParse()
    {
        $parser = new WordstatParser();
        $parser->start(0);
    }

    public function actionAddKeywords()
    {
        $keyword = Yii::app()->request->getPost('keyword');

        $allSearch = Yii::app()->search
            ->select('*')
            ->from('keywords')
            ->where(' ' . $keyword . ' ')
            ->limit(0, 100000)
            ->searchRaw();
        $count = 0;
        foreach ($allSearch['matches'] as $key => $m)
            if (ParsingKeyword::addKeyword($key))
                $count++;

        echo CJSON::encode(array(
            'status' => true,
            'count' => $count
        ));
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

    public function actionSearchKeyword()
    {
        $name = Yii::app()->request->getPost('name');
        $model = Keyword::model()->findByAttributes(array('name' => $name));

        if ($model !== null)
            echo CJSON::encode(array(
                'status' => true,
                'html' => $this->renderPartial('keyword', array(), true)
            ));
        else
            echo CJSON::encode(array(
                'status' => false,
            ));
    }

    public function actionLastKeywords()
    {

        $this->render('lastKeywords');
    }

    public function actionAdd()
    {
        $keywords = Yii::app()->request->getPost('keywords');
        $keywords = explode("\n", $keywords);
        foreach ($keywords as $keyword) {
            $keyword = Keyword::GetKeyword(trim($keyword));
            if (ParsingKeyword::model()->findByPk($keyword->id) === null) {
                $parsing = new ParsingKeyword;
                $parsing->keyword_id = $keyword->id;
                $parsing->save();
            }
        }

        echo CJSON::encode(array('status' => true));
    }

    public function actionTest(){
        $parser = new WordstatParser();
        $parser->start(1);
    }
}
