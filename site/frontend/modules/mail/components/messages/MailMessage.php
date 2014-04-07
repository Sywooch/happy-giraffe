<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 04/04/14
 * Time: 10:31
 * To change this template use File | Settings | File Templates.
 */

abstract class MailMessage extends CComponent
{
    abstract public function getTitle();
    abstract public function getBody();

    public $userId;
    public $type;
    public $html;

    private $token;

    public function __construct($userId)
    {
        $this->userId = $userId;
        $this->html = $html = Yii::app()->renderFile(Yii::getPathOfAlias('site.common.tpl') . DIRECTORY_SEPARATOR . 'contest_12.php', array(), true);
    }

    protected function replaceUrls()
    {
        $dom = str_get_html($this->html);
        foreach ($dom->find('a') as $link) {
            $href = $link->getAttribute('href');
            $newHref = Yii::app()->createUrl('/mail/default/auth', array('redirectUrl' => $href, 'token' => $this->getToken()->hash));
            $link->setAttribute('href', $newHref);
        }
        $this->html = $dom->save();
    }

    /**
     * @return MailToken
     */
    public function getToken()
    {
        if ($this->token === null) {
            $this->token = $this->createToken();
        }
        return $this->token;
    }

    /**
     * @param MailToken $token
     */
    public function setToken(MailToken $token)
    {
        $this->token = $token;
    }

    /**
     * @return MailToken
     */
    protected function createToken()
    {
        $token = new MailToken();
        $token->user_id = $this->userId;
        $token->expires = time() + $this->getTokenLifetime();
        $token->hash = md5(uniqid($this->userId, true));
        $token->save();
        return $token;
    }

    /**
     * @return MailDelivery
     */
    protected function createDelivery()
    {
        $delivery = new MailDelivery();
        $delivery->user_id = $this->userId;
        $delivery->type = $this->type;
        $delivery->save();
        return $delivery;
    }

    /**
     * @return int
     */
    protected function getTokenLifetime()
    {
        return 48 * 60 * 60;
    }

    protected function getTemplate()
    {
        return Yii::getPathOfAlias('site.frontend.modules.mail.tpls') . DIRECTORY_SEPARATOR . $this->type . '.php';
    }
}