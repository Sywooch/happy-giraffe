<?php

class DefaultController extends SController
{
    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('admin') && !Yii::app()->user->checkAccess('superuser'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    public function actionIndex($site_id = 1, $year = 2011, $recOnPage = 10)
    {
        $model = new KeyStats;
        $model->site_id = $site_id;
        $model->year = $year;

        $this->render('index', compact('model', 'site_id', 'year', 'recOnPage'));
    }

    public function actionCalc()
    {
        $site_id = 2;
        $year = 2012;
        $criteria = new CDbCriteria;
        $criteria->compare('site_id', $site_id);
        $criteria->compare('year', $year);
        $stats = Stats::model()->findAll($criteria);
        foreach ($stats as $stat) {
            $key_stat = KeyStats::model()->find('site_id = ' . $site_id . ' AND keyword_id = ' . $stat->keyword_id . ' AND year = ' . $year);
            if ($key_stat === null) {
                $key_stat = new KeyStats;
                $key_stat->keyword_id = $stat->keyword_id;
                $key_stat->site_id = $site_id;
                $key_stat->year = $year;
            }
            $key_stat->setAttribute('m' . $stat->month, $stat->value);
            $key_stat->save();
        }
    }

    public function actionAddKeys()
    {
        $file = fopen('F:\Xedant\Keywords.txt', 'r');
        $i = 0;
        $sql = '';
        $continue = false;
        if ($file) {
            while (($buffer = fgets($file)) !== false) {
                $i++;
                $keyword = trim(ltrim($buffer, '#'));
                $keyword = str_replace("'", '', $keyword);
                $keyword = str_replace("\\", '', $keyword);

                if ($keyword == 'приказ министра обороны 310 1999г')
                    $continue = true;

                if ($continue) {
                    $sql .= 'INSERT INTO keywords (`id` ,`name`)VALUES (NULL ,  \'' . $keyword . '\');';

                    if ($i % 2000 == 0) {
                        $command = Yii::app()->db_seo->createCommand($sql);
                        $command->execute();
                        $sql = '';
                    }
                }
            }
            if (!feof($file)) {
                echo "Error: unexpected fgets() fail\n";
                Yii::app()->end();
            }
            fclose($file);
        }
    }

    public function actionTransferData()
    {
        $articles = Yii::app()->db_seo2->createCommand()
            ->select('*')
            ->from('article_keywords')
            ->queryAll();

        foreach ($articles as $article) {

            $new_article = new ArticleKeywords();
            $new_article->entity = $article['entity'];
            $new_article->entity_id = $article['entity_id'];
            $new_article->url = $article['url'];

            $keyword_group = new KeywordGroup();
            $keyword_group->save();

            $new_article->keyword_group_id = $keyword_group->id;
            $new_article->save();

            //echo $article['url'].'<br>';
            $keywords = Yii::app()->db_seo2->createCommand()
                ->select('keyword_id')
                ->from('keyword_group_keywords')
                ->where('group_id=' . $article['keyword_group_id'])
                ->queryColumn();
            foreach ($keywords as $keyword) {
                $key = Yii::app()->db_seo2->createCommand()
                    ->select('name')
                    ->from('keywords')
                    ->where('id=' . $keyword)
                    ->queryScalar();

                $key = str_replace('.', ',', $key);
                $keys = explode(',', $key);

                foreach ($keys as $key2) {
                    $key2 = trim($key2);
                    if (!empty($key2)) {
                        $final_keyword_name = mb_strtolower(trim($key2), 'utf8');
                        $final_keyword = Keywords::model()->findByAttributes(array('name' => $final_keyword_name));
                        if ($final_keyword === null) {
                            $final_keyword = new Keywords;
                            $final_keyword->name = $final_keyword_name;
                            $final_keyword->save();
                        }

                        try {
                            Yii::app()->db_seo->createCommand()
                                ->insert('keyword_group_keywords', array(
                                'keyword_id' => $final_keyword->id,
                                'group_id' => $keyword_group->id
                            ));
                        } catch (Exception $e) {

                        }
                    }
                }
            }
        }
    }

    public function actionTest2()
    {
        echo Yii::app()->db_seo->createCommand('select count(keyword_id) from yandex_popularity')->queryScalar();
        echo '<br>';
        echo ParseHelper::getLine(0) . '<br>';
        echo ParseHelper::getLine(1) . '<br>';
        echo ParseHelper::getLine(2) . '<br>';
        echo ParseHelper::getLine(3) . '<br>';
        echo ParseHelper::getLine(4) . '<br>';
        echo ParseHelper::getLine(5) . '<br>';
        echo ParseHelper::getLine(6) . '<br>';
        echo ParseHelper::getLine(7) . '<br>';
        echo ParseHelper::getLine(8) . '<br>';
        echo ParseHelper::getLine(9) . '<br>';
        echo ParseHelper::getLine(10) . '<br>';
    }

    public function actionTest3()
    {
        $metrica = new YandexMetrica();
        $metrica->getData();

    }
}