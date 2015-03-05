<?php
/**
 * @author Никита
 * @date 05/03/15
 */

class MailQuestionsParser
{
    const BASE_URL = 'http://otvet.mail.ru';

    public $emails = array();
    protected $processedQuestions = array();
    protected $processedProfiles = array();

    public function run()
    {
        $i = 0;
        do {
            $i++;
            $url = self::BASE_URL . '/family/?pg=' . $i;
            $this->processPage($url);
        } while (count($this->emails) < 50000);
    }

    protected function processPage($url)
    {
        $html = file_get_contents($url);
        $doc = str_get_html($html);
        $questionsLinks = $doc->find('.list a.blue');
        $questionUrls = array_map(function($a) {
            return $a->href;
        }, $questionsLinks);
        foreach ($questionUrls as $url) {
            $this->processQuestion($url);
        }
    }

    protected function processQuestion($url)
    {
        if (array_search($url, $this->processedQuestions) !== false) {
            return;
        }

        $html = file_get_contents(self::BASE_URL . $url);
        $doc = str_get_html($html);
        $links = $doc->find('a[href*=profile]');
        $urls = array_map(function($a) {
            return $a->href;
        }, $links);
        foreach ($urls as $url) {
            $this->processProfile($url);
        }
        $this->processedQuestions[] = $url;

        echo count($this->emails) . "\n";
    }

    protected function processProfile($url)
    {
        if (array_search($url, $this->processedProfiles) !== false) {
            return;
        }

        $html = file_get_contents(self::BASE_URL . $url);
        $doc = str_get_html($html);
        $links = $doc->find('.list_profile a');
        foreach ($links as $link) {
            if (preg_match('#\/\/my.mail.ru\/(mail|inbox|bk|list)\/(\d*[a-zA-Z][a-zA-Z\d]*)\/$#', $link->href, $matches)) {
                $email = $matches[2] . '@' . $matches[1] . '.ru';
                $this->emails[] = $email;
            }
        }
        $this->processedProfiles[] = $url;
    }
}