<?php
/**
 * @author Никита
 * @date 03/04/15
 */

class MailForumParser
{
    const URL = 'https://deti.mail.ru';

    protected $processedTopics = array();
    protected $emails = array();

    public function run($callback)
    {
        $i = 1;
        while (true) {
            $this->processPage($i);
            $i++;
            call_user_func($callback, $this->emails);
            echo count($this->emails) . "\n";
        }
    }

    protected function processPage($page)
    {
        $url = self::URL . '/forum/nashi_deti/ot_rozhdenija_do_goda/?' . http_build_query(array(
            'sort' => 'new',
            'page' => $page,
        ));

        $html = $this->makeRequest($url);
        $doc = str_get_html($html);
        $links = $doc->find('.b-forum-topics__item__title a');
        foreach ($links as $link) {
            $this->processTopic($link->href);
        }
    }

    protected function processTopic($url)
    {
        $html = $this->makeRequest(self::URL . $url);

        preg_match_all('#<a href="\/(\w+)\/(.*)\/" class="b-forum-username">#', $html, $matches, PREG_SET_ORDER);

        foreach ($matches as $m) {
            $email = $m[2] . '@' . $m[1] . '.ru';
            if (array_search($email, $this->emails) === false) {
                $this->emails[] = $email;
            }
        }
    }

    protected function makeRequest($url)
    {
        do {
            $response = file_get_contents($url);
            if ($response === false) {
                sleep(10);
            } else {
                sleep(1);
            }
        } while($response === false);
        return $response;
    }
}