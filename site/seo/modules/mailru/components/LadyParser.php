<?php
/**
 * Author: alexk984
 * Date: 31.10.12
 */
class LadyParser extends LiBaseParser
{
    /**
     * @var MailruQuery
     */
    private $query;
    public $page = '';
    private $text = '@Mail.Ru';

    public static function gatherForums()
    {
        for ($i = 20; $i < 100; $i++) {
            $url = 'http://forum.lady.mail.ru/topics.html?fid=' . $i . '&ord=a';
            $html = file_get_contents($url);
            $html = iconv("Windows-1251", "UTF-8", $html);
            if (strpos($html, 'Нет такого форума'))
                echo 'bad forum';
            else {
                Yii::app()->db_seo->createCommand()->insert('mailru__queries', array('text' => $url));
            }
        }
    }

    public function start()
    {
        while (true) {
            $this->getPage();

            while (!empty($this->page))
                $this->parsePage();

            $this->closeQuery();
        }
    }

    public function getPage()
    {
        echo "get page\n";

        $criteria = new CDbCriteria;
        $criteria->compare('active', 0);
        $criteria->compare('type', 0);

        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            $this->query = MailruQuery::model()->find($criteria);

            $this->query->active = 1;
            $this->query->save();
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            echo 'fail';
            Yii::app()->end();
        }

        echo "get loaded\n";

        $this->page = 1;
    }

    public function parsePage()
    {
        $query = $this->query->text . '&pg=' . $this->page;
        $content = $this->loadPage($query, $this->text);

        $document = phpQuery::newDocument($content);
        $count = 0;
        foreach ($document->find('div.themehead > a.t120') as $link) {
            $url = pq($link)->attr('href');
            $this->addTheme($url);
            $count++;
        }

        $document->unloadDocument();

        if ($count == 20)
            $this->page++;
        else
            $this->page = null;
    }

    public function addTheme($url)
    {
        $exist = MailruQuery::model()->findByAttributes(array('text' => $url));
        if ($exist === null) {
            $user = new MailruQuery();
            $user->text = $url;
            $user->type = 1;
            $user->save();
        }
    }

    private function closeQuery()
    {
        $this->query->active = 2;
        $this->query->save();
    }
}

