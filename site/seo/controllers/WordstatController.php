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
            if (ParsingKeyword::model()->addKeywordByIdNotInYandex($key))
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
        foreach ($keywords as $keyword) {
            if (ParsingKeyword::model()->addKeywordById($keyword))
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
                'html' => $this->renderPartial('keyword', array('yandex' => $model->yandex), true)
            ));
        else
            echo CJSON::encode(array(
                'status' => false,
            ));
    }
}
