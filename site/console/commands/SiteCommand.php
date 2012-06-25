<?php
/**
 * Author: choo
 * Date: 14.05.2012
 */
class SiteCommand extends CConsoleCommand
{
    private $recipients = array(
        'choojoy.work@gmail.com',
        'alexk984@gmail.com',
        'lnghost@hotmail.com',
    );

    public function actionCheckSeo()
    {
        //robots
        $url = 'http://www.happy-giraffe.ru/robots.txt';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $robotsResult = $httpStatus == 200;

        //sitemap
        $url = 'http://www.happy-giraffe.ru/sitemap.xml';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $sitemapResult = simplexml_load_string($response) !== FALSE;

        $output =
            'robots.txt - ' . ($robotsResult ? 'OK' : 'BROKEN') . "\n" .
                'sitemap.xml - ' . ($sitemapResult ? 'OK' : 'BROKEN') . "\n"
        ;

        if (!($robotsResult && $sitemapResult)) {
            mail(implode(', ', $this->recipients), 'happy-giraffe.ru seo check failure', $output);
        }
    }

    public $moderators = array(23, 83, 10023, 10264, 10064);
    public $smo = array(12998, 13093, 13130, 13094, 13217);
    public $editors = array(10379, 10378, 10265, 12949, 10385, 10384, 13361, 13107, 12950, 13096,
        13235, 13122, 10433, 13002, 13105, 13099, 12411, 13101, 13103, 13098, 10358, 13136, 10359, 13137, 10391);

    /**
     * mark all users with role
     */
    public function actionUserGroups(){
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->moderators);

        $users = User::model()->findAll($criteria);
        foreach($users as $user){
            $user->group = UserGourp::MODERATOR;
            $user->update('group');
        }

        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->smo);

        $users = User::model()->findAll($criteria);
        foreach($users as $user){
            $user->group = UserGourp::SMO;
            $user->update('group');
        }

        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->editors);

        $users = User::model()->findAll($criteria);
        foreach($users as $user){
            $user->group = UserGourp::EDITOR;
            $user->update('group');
        }

        //virtuals
        $users = Yii::app()->db->createCommand('select distinct(userid) from auth__assignments where itemname="virtual_user"')->queryColumn();
        foreach($users as $user_id){
            $user = User::getUserById($user_id);
            $user->group = UserGourp::VIRTUAL;
            $user->update('group');
        }
    }
}