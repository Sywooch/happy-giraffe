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
    public $userId;
    public $type;
    public $bodyHtml;

    private $token;

    public function __construct($userId, $params = array())
    {
        $this->userId = $userId;
        foreach ($params as $k => $v)
            $this->$k = $v;
        /**
         * @var CConsoleApplication $app
         */
        $app = Yii::app();
        $this->bodyHtml = $app->getCommandRunner()->getCommand()->renderFile($this->getTemplate(), $params, true);
    }

    abstract public function getSubject();

    public function getBody()
    {
        return $this->bodyHtml;
    }

    protected function replaceUrls()
    {
        $dom = str_get_html($this->bodyHtml);
        foreach ($dom->find('a') as $link) {
            $href = $link->getAttribute('href');
            $newHref = Yii::app()->createUrl('/mail/default/auth', array('redirectUrl' => $href, 'token' => $this->getToken()->hash));
            $link->setAttribute('href', $newHref);
        }
        $this->bodyHtml = $dom->save();
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