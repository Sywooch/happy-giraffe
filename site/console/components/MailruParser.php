<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 21/11/13
 * Time: 14:03
 * To change this template use File | Settings | File Templates.
 */

class MailruParser extends ProxyParserThread
{

    public $use_proxy = false;
    protected $type;
    protected $types = array(
        MailruUser::LIST_PlANNING => 'planning',
        MailruUser::LIST_PREGNANCY => 'pregnancy',
        MailruUser::LIST_CHILD => 'child',
    );

    public function __construct($threadId, $type)
    {
        $this->thread_id = $threadId;
        $this->type = $type;
    }

    public function start()
    {
        $i = 1;
//        for ($i = $this->thread_id; ; $i += 100) {
            $url = 'http://deti.mail.ru/community/?status=' . $this->types[$this->type] . '&show_all=yes&page=' . $i;
            $response = $this->query($url);
            $this->parseQuery($response);
//        }
    }

    public function parseQuery($response)
    {
        $html = str_get_html($response);
        foreach ($html->find('.b-mypage-social__card') as $user) {
            $nameElement = $user->find('.b-mypage-social__card__name__link', 0);
            $name = $nameElement->plaintext;
            $namePieces = explode(' ', $name);
            list($firstName, $lastName) = $namePieces;
            $geo = $user->find('.b-mypage-social__card__date__link', 0)->plaintext;
            $innerUrl = $nameElement->href;
            $url = 'http://deti.mail.ru' . $innerUrl;
            $email = preg_replace('#^\/(.*)\/(.*)\/$#', '$2@$1.ru', $innerUrl);
            $gender = (strpos($user->class, 'b-mypage-social__card_male')) ? 1 : 0;
            $age = intval($user->find('.b-mypage-social__card__date', 1)->plaintext);
            $type = $this->type;
            $pregnancyWeek = (($blob = $user->find('.i-blob', 0)) !== null) ? $blob->plaintext : null;
            $kidsElement = $user->find('.b-user__kids', 0);
            if ($kidsElement !== null) {
                $kids = array_map(function($a) {
                    return array(
                        'name' => $a->find('.link-ico__text', 0)->plaintext,
                        'url' => 'http://deti.mail.ru' . $a->href,
                        'gender' => strpos($a->class, 'i-kid_child-male') ? 1 : 0,
                    );
                }, $kidsElement->find('a'));
                foreach ($kidsElement->find('.b-user__kids__age') as $k => $v)
                    $kids[$k]['age'] = $v->plaintext;
            }

            $attributes = compact('firstName', 'lastName', 'geo', 'url', 'email', 'gender', 'age', 'type', 'pregnancyWeek');
            foreach ($attributes as $k => $v)
                echo $k . ': ' . $v . "\n";

            echo "\n";
            break;
        }
    }
}