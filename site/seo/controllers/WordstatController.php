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

    public function actionParsePastuhov()
    {
        $fh = fopen(Yii::app()->params['pastuh_yandex_filepath'] , 'r');
        for ($i = 0; $i < 4000000; $i++)
            fgets($fh);
        while ($str = fgets($fh)) {
            preg_match('/([^|]+)\|([\d]+)/', $str, $matches);
            if (isset($matches[2]) && $matches[2]>5000){
                $keyword = $matches[1];
                $keyword = preg_replace('/(\+)[\w]*/', '', $keyword);
                $keyword = str_replace('$', '', $keyword);
                $keyword = str_replace('&', '', $keyword);
                $keyword = str_replace('"', '', $keyword);
                $keyword = str_replace('\'', '', $keyword);
                $keyword = trim($keyword);

                $model = Keyword::model()->findByAttributes(array('name'=>$keyword));
                if ($model === null){
                    $model = new Keyword();
                    $model->name = $keyword;
                    $model->save();

                    $parsing_keyword = new ParsingKeyword();
                    $parsing_keyword->keyword_id = $model->id;
                    $parsing_keyword->theme = 100;
                    $parsing_keyword->save();
                }
            }
        }

        fclose($fh);
    }

    public function actionLastKeywords(){

        $this->render('lastKeywords');
    }
}
