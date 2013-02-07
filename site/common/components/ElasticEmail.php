<?php
/**
 * Author: alexk984
 * Date: 10.01.13
 */
class ElasticEmail extends CApplicationComponent
{
    const USERNAME = 'mira.smurkov@gmail.com';
    const KEY = 'd0fbfc41-7591-4da4-b587-ab54fe263665';

    public static function send($to, $subject, $body_html, $from, $fromName)
    {
        $res = "";

        $data = "username=" . urlencode(self::USERNAME);
        $data .= "&api_key=" . urlencode(self::KEY);
        $data .= "&from=" . urlencode($from);
        $data .= "&from_name=" . urlencode($fromName);
        $data .= "&to=" . urlencode($to);
        $data .= "&subject=" . urlencode($subject);
        if ($body_html)
            $data .= "&body_html=" . urlencode($body_html);
//        if($body_text)
//            $data .= "&body_text=".urlencode($body_text);

        $header = "POST /mailer/send HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($data) . "\r\n\r\n";
        $fp = fsockopen('ssl://api.elasticemail.com', 443, $errno, $errstr, 30);

        if (!$fp)
            return "ERROR. Could not open connection";
        else {
            fputs($fp, $header . $data);
            while (!feof($fp)) {
                $res .= fread($fp, 1024);
            }
            fclose($fp);
        }
        return $res;
    }

    public static function sendCampaign($body, $list, $template = 'weekly_news')
    {
        $res = "";

        $data = "username=" . urlencode(self::USERNAME);
        $data .= "&api_key=" . urlencode(self::KEY);
        $data .= "&from=" . urlencode('noreply@happy-giraffe.ru');
        $data .= "&from_name=" . urlencode('Веселый Жираф');
        $data .= "&template=" . urlencode($template);
        $data .= "&merge_htmlbody=" . urlencode($body);
        $data .= "&lists=" . 'test_list';
//        if($body_text)
//            $data .= "&body_text=".urlencode($body_text);

        $header = "POST /mailer/send HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($data) . "\r\n\r\n";
        $fp = fsockopen('ssl://api.elasticemail.com', 443, $errno, $errstr, 30);

        if (!$fp)
            return "ERROR. Could not open connection";
        else {
            fputs($fp, $header . $data);
            while (!feof($fp)) {
                $res .= fread($fp, 1024);
            }
            fclose($fp);
        }
        echo $res;
    }

    public static function addContact($email, $first_name, $last_name, $list)
    {
        $res = "";

        $data = "username=" . urlencode(self::USERNAME);
        $data .= "&api_key=" . urlencode(self::KEY);
        $data .= "&email=" . urlencode($email);
        $data .= "&listname=" . $list;
        $data .= "&firstname=" . urlencode($first_name);
        $data .= "&lastname=" . urlencode($last_name);

        $header = "POST /lists/create-contact HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($data) . "\r\n\r\n";
        $fp = fsockopen('ssl://api.elasticemail.com', 443, $errno, $errstr, 30);

        if (!$fp)
            return "ERROR. Could not open connection";
        else {
            fputs($fp, $header . $data);
            while (!feof($fp)) {
                $res .= fread($fp, 1024);
            }
            fclose($fp);
        }

        if (strpos($res, 'contact already exists') !== false)
            self::addExistingContact($email, $list);

//        var_dump($res);

        return $res;
    }

    public static function addExistingContact($email, $list)
    {
        $res = "";

        $data = "username=" . urlencode(self::USERNAME);
        $data .= "&api_key=" . urlencode(self::KEY);
        $data .= "&email=" . urlencode($email);
        $data .= "&listname=" . $list;

        $header = "POST /lists/add-contact HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($data) . "\r\n\r\n";
        $fp = fsockopen('ssl://api.elasticemail.com', 443, $errno, $errstr, 30);

        if (!$fp)
            return "ERROR. Could not open connection";
        else {
            fputs($fp, $header . $data);
            while (!feof($fp)) {
                $res .= fread($fp, 1024);
            }
            fclose($fp);
        }

//        var_dump($res);

        return $res;
    }
}
