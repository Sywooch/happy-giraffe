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
        $this->bodyHtml = Yii::app()->controller->renderFile($this->getTemplate(), array('message' => $this), true);
    }

    abstract public function getSubject();

    public function getBody()
    {
        return $this->bodyHtml;
    }

    public function createUrl($url, $utmContent = null)
    {
        if (is_array($url))
        {
            if (isset($url[0]))
            {
                    $url = Yii::app()->createAbsoluteUrl($url[0], array_splice($url, 1));
            }
            else
                $url = '';
        }
        $url = $this->addTokenHash($this->addUtmTags($url, $utmContent));
        return $url;
    }

    protected function addTokenHash($url)
    {
        return Yii::app()->createAbsoluteUrl('/mail/default/auth', array('redirectUrl' => urlencode($url), 'hash' => $this->getToken()->hash));
    }

    protected function addUtmTags($url, $utmContent)
    {
        $utm = array(
            'utm_source' => 'happygiraffe',
            'utm_medium' => 'email',
            'utm_campaign' => $this->type,
        );
        if ($utmContent !== null)
            $utm['utm_content'] = $utmContent;

        $utmString = http_build_query($utm);
        $glue = (strpos('?', $url) === false) ? '?' : '&';
        return $url . $glue . $utmString;
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