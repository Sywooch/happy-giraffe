<?php
/**
 * Класс для аутентификации пользователей, перешедших по ссылке в письме
 */

class MailTokenUserIdentity extends CBaseUserIdentity
{
    const TOKEN_DOES_NOT_EXIST = 3;
    const TOKEN_EXPIRED = 4;

    public $hash;

    public function __construct($hash)
    {
        $this->hash = $hash;
    }

    public function authenticate()
    {
        /**
         * @var MailToken $token
         */
        $token = MailToken::model()->findByAttributes(array(
            'hash' => $this->hash,
        ), array(
            'with' => array(
                'user',
            ),
        ));
        if ($token === null) {
            $this->errorCode = self::TOKEN_DOES_NOT_EXIST;
            $this->errorMessage = 'Токен не существует';
        } elseif (time() > $token->expires) {
            $this->errorCode = self::TOKEN_EXPIRED;
            $this->errorMessage = 'Срок действия токена истек';
        } else {
            foreach ($token->user->attributes as $k => $v)
                $this->setState($k, $v);
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode == self::ERROR_NONE;
    }

    public function getId()
    {
        return $this->getState('id');
    }

    public function getName()
    {
        return $this->getState('first_name');
    }
}