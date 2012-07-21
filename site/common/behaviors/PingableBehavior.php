<?php
/**
 * Author: choo
 * Date: 21.07.2012
 */
class PingableBehavior extends CActiveRecordBehavior
{
    public function attach($owner)
    {
        parent::attach($owner);

        $owner->attachEventHandler('onAfterSave', array($this, 'send'));
    }

    public function detach($owner)
    {
        parent::detach($owner);

        $owner->detachEventHandler('onAfterSave', array($this, 'send'));
    }

    public function send()
    {
        if (get_class($this->owner) == 'CommunityContent' && ($this->owner->type_id == 4 || $this->owner->by_happy_giraffe)) {
            $pingUserId = 1;
        } else {
            $pingUserId = $this->owner->author_id;
        }
        $pingName = 'Блог пользователя ' . $this->owner->author->fullName;
        $pingUrl = Yii::app()->createAbsoluteUrl('rss/user', array('user_id' => $pingUserId));

        $xmlDoc = new DOMDocument;
        $methodCall = $xmlDoc->createElement('methodCall');
        $xmlDoc->appendChild($methodCall);
        $methodCall->appendChild($xmlDoc->createElement('methodName', 'weblogUpdates.ping'));
        $params = $xmlDoc->createElement('params');
        $methodCall->appendChild($params);
        $param = $xmlDoc->createElement('param');
        $param->appendChild($xmlDoc->createElement('value', $pingName));
        $params->appendChild($param);
        $param = $xmlDoc->createElement('param');
        $param->appendChild($xmlDoc->createElement('value', $pingUrl));
        $params->appendChild($param);
        $xml = $xmlDoc->saveXML();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://ping.blogs.yandex.ru/RPC2');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

        Yii::log($output, 'error');
        $this->owner->sent = true;
    }
}
