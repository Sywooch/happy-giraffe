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
    public $user;
    public $type;
    public $bodyHtml;

    /**
     * @property MailToken $token
     */
    protected $token;

    /**
     * @property MailDelivery $delivery
     */
    public $delivery;

    abstract public function getSubject();

    public function __construct(User $user, $params = array())
    {
        $this->user = $user;
        foreach ($params as $k => $v)
            $this->$k = $v;

        $this->token = $this->createToken();
        $this->delivery = $this->createDelivery();

        /**
         * @var CConsoleApplication $app
         */
        $app = Yii::app();
        $this->bodyHtml = $app->getCommandRunner()->getCommand()->renderFile($this->getTemplate(), array('message' => $this), true);
    }

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
                throw new CException('Wrong url parameter');
        }
        $url = $this->addTokenHash($this->addUtmTags($url, $utmContent));
        return $url;
    }

    protected function addTokenHash($url)
    {
        return Yii::app()->createAbsoluteUrl('/mail/default/redirect', array('redirectUrl' => urlencode($url), 'tokenHash' => $this->token->hash, 'deliveryHash' => $this->delivery->hash));
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
    protected function createToken()
    {
        $token = new MailToken();
        $token->user_id = $this->user->id;
        $token->expires = time() + $this->getTokenLifetime();
        $token->hash = $this->getUniqueHash();
        $token->save();
        return $token;
    }

    protected function createDelivery()
    {
        $delivery = new MailDelivery();
        $delivery->user_id = $this->user->id;
        $delivery->type = $this->type;
        $delivery->hash = $this->getUniqueHash();
        $delivery->save();
        return $delivery;
    }

    protected function getUniqueHash()
    {
        return md5(uniqid($this->user->id, true));
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