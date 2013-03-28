<?php
/**
 * Author: alexk984
 * Date: 31.10.12
 */
class LedyForumParser extends LiBaseParser
{
    /**
     * @var MailruQuery
     */
    private $query;
    public $page = '';
    private $text = '@Mail.Ru';

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
        $criteria = new CDbCriteria;
        $criteria->compare('active', 0);
        $criteria->compare('type', 1);

        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            $this->query = MailruQuery::model()->find($criteria);
            if ($this->query === null)
                Yii::app()->end();

            $this->query->active = 1;
            $this->query->save();
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
        }

        $this->page = 1;
    }

    public function parsePage()
    {
        $html = $this->loadPage('http://forum.lady.mail.ru'.$this->query->text . '?pg=' . $this->page, $this->text);
        $html = iconv("Windows-1251", "UTF-8", $html);

        $count = $this->parseHtml($html);

        if ($count > 0) {
            $this->page++;
        } else
            $this->page = null;
    }

    public function parseHtml($html)
    {
        $count = 0;
        $r = '`\<a href="http://my.mail.ru/([^"]+)" [^>]+>([^<]+)<`ism';
        preg_match_all($r, $html, $matches);
        for ($i = 0; $i < count($matches[0]); $i++) {
            $url = 'http://my.mail.ru/' . $matches[1][$i];
            $email = $this->calculateEmail($url);
            $name = $matches[2][$i];

            $this->addUser($email, $name, $url);
            $count++;
        }

        return $count;
    }

    public function calculateEmail($email)
    {
        preg_match('/http:\/\/my.mail.ru\/(.+)\/(.+)\//', $email, $match);
        if (count($match) == 3) {
            return trim($match[2] . '@' . $match[1] . '.ru');
        }

        return null;
    }

    public function addUser($email, $name, $url)
    {
        $user = new MailruUser();
        $user->email = $email;
        if (!empty($user->email) && MailruUser::model()->findByAttributes(array('email' => $user->email)) == null) {
            $user->name = trim($name);
            $user->moi_mir_url = trim($url);
            try {
                $user->save();
            } catch (Exception $e) {
            }
        }
    }

    private function closeQuery()
    {
        $this->query->active = 2;
        $this->query->save();
    }
}

