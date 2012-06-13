<?php

class DefaultController extends SController
{
    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('admin') && !Yii::app()->user->checkAccess('superuser'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    /*public function actionAddKeys()
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
    }*/

    public function actionTest2()
    {
        /*echo Yii::app()->db_seo->createCommand('select count(keyword_id) from rambler_popularity')->queryScalar();
        echo '<br>';
        for($i=0;$i<25;$i++){
            echo ParseHelper::getLine($i) . '<br>';
        }*/
    }
}