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
        $data .= "&lists=" . $list;

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

    public static function uploadUserList($filename, $list)
    {
        $data = "username=" . urlencode(self::USERNAME);
        $data .= "&api_key=" . urlencode(self::KEY);
        $data .= "&listname=" . urlencode($list);
        $data .= "&listname=" . $list;

        $header = "POST /lists/add-contact HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($data) . "\r\n\r\n";
        $fp = fsockopen('ssl://api.elasticemail.com', 443, $errno, $errstr, 30);

        $res = "";

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

    /*public static function deleteCleanedUsers()
    {
        Yii::import('site.seo.modules.mailru.models.*');
        if (($handle = fopen("F:/cleaned_Contest_List_2_1_Feb_11_2013.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $user = MailruUser::model()->findByAttributes(array('email'=>$data[0]));
                if ($user !== null){
                    $user->status = MailruUser::STATUS_CLEANED;
                    $user->save();
                }
            }
            fclose($handle);
        }
    }

    public static function deleteUnsubscribedUsers()
    {
        Yii::import('site.seo.modules.mailru.models.*');
        if (($handle = fopen("F:/unsubscribed_Contest_List_2_1_Feb_11_2013.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $user = MailruUser::model()->findByAttributes(array('email'=>$data[0]));
                if ($user !== null){
                    $user->status = MailruUser::STATUS_UNSUB;
                    $user->save();
                }
            }
            fclose($handle);
        }
    }*/

    public static function markGoodEmails()
    {
        Yii::import('site.seo.modules.mailru.models.*');
        if (($handle = fopen("F:/segment_Contest_List_2_1_Feb_11_2013.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, null, ",")) !== FALSE) {
                $user = MailruUser::model()->findByAttributes(array('email'=>$data[0]));
                if ($user !== null){
                    $user->status = MailruUser::STATUS_GOOD;
                    $user->save();
                }
            }
            fclose($handle);
        }
    }

    public static function deleteContact($email)
    {
        $data = "username=" . urlencode(self::USERNAME);
        $data .= "&api_key=" . urlencode(self::KEY);
        $data .= "&email=" . urlencode($email);

        $header = "POST /lists/delete-contact HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($data) . "\r\n\r\n";
        $fp = fsockopen('ssl://api.elasticemail.com', 443, $errno, $errstr, 30);

        $res = "";

        if (!$fp)
            return "ERROR. Could not open connection";
        else {
            fputs($fp, $header . $data);
            while (!feof($fp)) {
                $res .= fread($fp, 1024);
            }
            fclose($fp);
        }
    }

    public static function deleteContactFromList($email, $list)
    {
        $data = "username=" . urlencode(self::USERNAME);
        $data .= "&api_key=" . urlencode(self::KEY);
        $data .= "&email=" . urlencode($email);
        $data .= "&listname=" . urlencode($list);

        $header = "POST /lists/remove-contact HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($data) . "\r\n\r\n";
        $fp = fsockopen('ssl://api.elasticemail.com', 443, $errno, $errstr, 30);

        $res = "";

        if (!$fp)
            echo "ERROR. Could not open connection";
        else {
            fputs($fp, $header . $data);
            while (!feof($fp)) {
                $res .= fread($fp, 1024);
            }
            fclose($fp);
        }
    }

    public static function deleteRegisteredFromContestList()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->condition = 'id > 100000';
        $criteria->offset = 0;

        $users = array(1);
        while (!empty($users)) {
            $users = User::model()->findAll($criteria);
            foreach($users as $user)
                self::deleteContactFromList($user->email, 'mailru_users');

            $criteria->offset += 100;
            //echo $criteria->offset . "\n";
        }
    }
}
