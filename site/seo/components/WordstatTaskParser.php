<?php
/**
 * Author: alexk984
 * Date: 13.03.13
 */
class WordstatTaskParser extends WordstatParser
{
    private $task;

    public function start($mode)
    {
        Yii::import('site.frontend.modules.cook.models.*');
        $this->init($mode);

        while (true) {
            $this->getNextPage();

            $success = false;
            while (!$success) {
                $success = $this->parseQuery();

                if (!$success) {
                    $this->fails++;
                    if ($this->fails > 10) {
                        $this->removeCookieFile();
                        $this->getCookie();
                        $this->fails = 0;
                    } else
                        $this->changeBadProxy();
                } else {
                    $this->success_loads++;
                    $this->fails = 0;
                }

                sleep(1);
            }
        }
    }

    public function getNextPage()
    {
        if (empty($this->next_page)) {
            $this->getKeyword();
            $t = urlencode($this->queryModify->prepareQuery($this->task->title));
            $this->next_page = 'http://wordstat.yandex.ru/?cmd=words&page=1&t=' . $t . '&geo=&text_geo=';
        }
    }

    public function getKeyword()
    {
        $this->first_page = true;

        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            $task_id = Yii::app()->db_seo->createCommand()->select('content_id')->from('parsing_task__task')->where('active=0')->queryScalar();
            Yii::app()->db_seo->createCommand()->update('parsing_task__task', array('active' => 1), 'content_id=' . $task_id);
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
        }

        $this->task = CookRecipe::model()->findByPk($task_id);
        $this->log('Parsing keyword: ' . $this->task->title);
    }

    public function parseData($html)
    {
        $this->log('parse page');

        $document = phpQuery::newDocument($html);
        $html = str_replace('&nbsp;', ' ', $html);
        $html = str_replace('&mdash;', '—', $html);

        //find and add our keyword
        if (preg_match('/— ([\d]+) показ[ов]*[а]* в месяц/', $html, $matches)) {
            $this->log('valid page loaded');
            if ($this->first_page) {
                Yii::app()->db_seo->createCommand()->update('parsing_task__task', array('wordstat' => $matches[1]), 'content_id=' . $this->task->id);
            }
            $this->log('wordstat value: ' . $matches[1]);
        } else return false;

        //find keywords in block "Что искали со словом"
        foreach ($document->find('table.campaign tr td table:first td a') as $link) {
            $keyword = trim(pq($link)->text());
            $value = (int)pq($link)->parent()->next()->next()->text();

            $model = $this->addData($keyword, $value);

            //добавляем в базу
            if ($model) {
                try {
                    Yii::app()->db_seo->createCommand()->insert('parsing_task__keywords', array(
                        'content_id' => $this->task->id,
                        'keyword_id' => $model->id,
                    ));
                } catch (Exception $e) {
                }
            }
        }

        //ищем ссылку на следующую страницу
        $this->next_page = '';
        foreach ($document->find('div.pages a') as $link) {
            $title = pq($link)->text();
            if (strpos($title, 'следующая') !== false)
                $this->next_page = 'http://wordstat.yandex.ru/' . pq($link)->attr('href');

        }

        if (!empty($this->next_page))
            $this->first_page = false;

        $document->unloadDocument();
        return true;
    }
}
