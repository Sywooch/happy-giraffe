<?php

class Test2Controller extends Controller
{
    public function actionCount()
    {
        $c = Community::model()->findByPk(1);
        echo $c->getCount(1);
    }

    public function actionFix()
    {
        $contents = CommunityContent::model()->findAll(array('select' => 'id, author_id', 'order' => 'id DESC'));
        foreach ($contents as $c)
        {
            echo 'UPDATE `club_community_content` SET `author_id`=' . $c->author_id . ' WHERE `id`=' . $c->id . ';' . "\n";
        }
    }

    public function actionIndex()
    {
        phpinfo();
        die;
        $this->widget('ext.blocks.BlockWidget', array(
            'params' => array(
                'url' => CController::createAbsoluteUrl('test/test'),
                'data' => array(
                    'label' => 'test',
                ),
            ),
        ));
    }

    public function actionTest()
    {
        //var_dump(Yii::app()->user->settlement_id);
        var_dump(Yii::app()->db->createCommand('SHOW INDEX FROM bag_offer_vote')->queryAll());
    }

    public function actionVideo()
    {
        $video = new Video('http://www.youtube.com/watch?v=6hQfzL18NDY');
        echo $video->title;
    }

    public function actionImport()
    {
        Yii::import('ext.excelReader.Spreadsheet_Excel_Reader');
        $data = new Spreadsheet_Excel_Reader('giraffe.xls');
        $i = 0;
        while ($community_name = $data->val(2, ++$i))
        {
            $community = new Community;
            $community->name = $community_name;
            $community->save(false);
            $j = 3;
            while ($rubric_name = $data->val(++$j, $i))
            {
                $rubric = new CommunityRubric;
                $rubric->name = $rubric_name;
                $rubric->community_id = $community->id;
                $rubric->save(false);
            }
        }
    }

    /*
    public function actionParseStats()
    {
        Yii::import('ext.phpQuery.phpQuery.phpQuery');
        for ($month = 8; $month > 0; $month--) {
            $url = 'http://www.liveinternet.ru/stat/blog.mosmedclinic.ru/queries.html?id=139;id=3224346;id=3138283;id=3224088;id=3225442;date=2011-'.$month.'-'.cal_days_in_month(CAL_GREGORIAN, $month, 2011).';period=month;total=yes;page=';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_COOKIE, 'session=0708ZM0mw8qJ; suid=0HL2kG3LzWGy; per_page=100; adv-uid=2d663d.2664c3.bcd35c'); // allow redirects
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); // times out after 4s
            $result = curl_exec($ch); // run the whole process
            curl_close($ch);

            $document = phpQuery::newDocument($result);
            $max_pages = 30;
            foreach ($document->find('table p a.high') as $link) {
                $name = trim(pq($link)->text());
                if (is_numeric($name))
                    $max_pages = $name;
            }
            echo $max_pages . '<br>';
            $res = array_merge(array(), $this->GetStat($document, $month));
            flush();
            sleep(5);

            for ($i = 2; $i <= $max_pages; $i++) {
                $page_url = $url . $i;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $page_url);
                curl_setopt($ch, CURLOPT_FAILONERROR, 1);
                curl_setopt($ch, CURLOPT_COOKIE, 'session=0708ZM0mw8qJ; suid=0HL2kG3LzWGy; per_page=100; adv-uid=2d663d.2664c3.bcd35c'); // allow redirects
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
                curl_setopt($ch, CURLOPT_TIMEOUT, 10); // times out after 4s
                $result = curl_exec($ch); // run the whole process
                curl_close($ch);

                $document = phpQuery::newDocument($result);
                $res = array_merge($res, $this->GetStat($document, $month));

                sleep(rand(3, 7));
            }
        }
    }

    private function GetStat($document, $month)
    {
        $year = 2011;

        $res = array();
        foreach ($document->find('table table') as $table) {
            $text = pq($table)->find('td:first')->text();
            //            echo $text.'<br>';
            if (strstr($text, 'значения:суммарные') !== FALSE) {
                $i = 0;
                foreach (pq($table)->find('tr') as $tr) {
                    $i++;
                    if ($i < 3)
                        continue;
                    $keyword = trim(pq($tr)->find('td:eq(1)')->text());
                    if (empty($keyword))
                        break;
                    $stats = trim(pq($tr)->find('td:eq(2)')->text());
                    $res[] = array($keyword, $stats);
                    //                    echo $keyword . ' ' . $stats . '<br>';
                    $keyword_model = SeoKeywords::GetKeyword($keyword);
                    $model = new SeoStats();
                    $model->month = $month;
                    $model->year = $year;
                    $model->keyword_id = $keyword_model->id;
                    $model->value = str_replace(',', '', $stats);
                    $model->SaveOrUpdate();
                }
            }
        }

        return $res;
    }

    private function Show($res)
    {
        foreach ($res as $r) {
            echo $r[0] . ' ' . $r[1] . '<br>';
        }

    }
*/

    public function actionStats()
    {
        $this->layout = 'none';
        if (Yii::app()->user->isGuest)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $keywords = SeoKeywords::model()->with(array(
            'seoStats' => array(
                'select' => array('month', 'value'),
            ),
        ))->findAll(array(
//            'limit' => 300
        ));
        usort($keywords, array('SeoKeywords', 'cmp_fun'));
        $this->render('stats3', array(
            'keywords' => $keywords,
        ));
    }

    public function actionAttach()
    {
        $user = User::model()->findByPk(38);
        var_dump($user->delCommunity(7));
    }

    public function actionRp($text)
    {
        $comet = new CometModel();
        $comet->send(38, array('text' => $text), CometModel::TYPE_NEW_WARNING);
    }

    public function actionNotifications()
    {
        $notifications = array(
            'count' => UserNotification::model()->getCount(Yii::app()->user->id),
            'data' => UserNotification::model()->getLast(Yii::app()->user->id),
        );

        $this->render('notifications', array(
            'notifications' => $notifications,
        ));
    }

    public function actionLol()
    {
        echo Yii::app()->user->model->delFriend(10097);
    }

    public function actionSmiles(){
        if ($handle = opendir('C:/WebServers/happy-giraffe/site/frontend/www/images/widget/smiles')) {
            while (false !== ($entry = readdir($handle))) {
                echo "'$entry',";
            }
            while ($entry = readdir($handle)) {
                echo "'$entry',\n";
            }

            closedir($handle);
        }
    }
}