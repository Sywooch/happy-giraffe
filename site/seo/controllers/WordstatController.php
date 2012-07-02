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

    public function actionWordstatParse(){
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

    public function actionClearParsingKeywords(){
        ParsingKeyword::model()->deleteAll();

        echo CJSON::encode(array('status' => true));
    }

    public function actionRemovePlus()
    {
        $end = false;
        $i = 0;

        $criteria = new CDbCriteria;
        $criteria->order = 'id';
        $criteria->limit = 1000;
        while (!$end) {
            $criteria->condition = 'id >= ' . ($i * 1000) . ' AND id < ' . ($i*1000 + 1000);
            $models = Keyword::model()->findAll($criteria);

            foreach ($models as $model) {
                if (preg_match_all('/\+([а-яА-Я]+)/', $model->name, $matches)) {
                    echo $model->name.'<br>';
                    $new_name = str_replace('+', '', $model->name);

                    $keyword = Keyword::model()->findByAttributes(array('name' => $new_name));
                    if ($keyword !== null) {
                        //$model->delete();
                    } else {
                        $model->name = $new_name;
                        //$model->save();
                    }
                }
            }

            $i++;
            if ($i%100 == 0)
                echo $i.'<br>';

            if ($i > 230000)
                $end = true;
        }
    }
}
