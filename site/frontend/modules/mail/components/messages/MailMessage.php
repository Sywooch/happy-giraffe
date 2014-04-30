<?php
/**
 * Сообщение
 *
 * Каждый экземпляр этого класса представляет собой готовое сообщение для отправки. Отвечает за генерацию письма
 * и все смежные действия
 */

abstract class MailMessage extends CComponent
{
    /**
     * Пользователь, для которого предназначено письмо
     *
     * @property User $user
     */
    public $user;

    /**
     * Тип письма. Используется как значение UTM-метки utm_campaign и в качестве названия шаблона по умолчанию
     *
     * @property string $type
     */
    public $type;

    /**
     * Тело письма
     *
     * @var string mixed
     */
    public $bodyHtml;

    /**
     * Аутентификационный токен
     *
     * @property MailToken $token
     */
    protected $token;

    /**
     * Модель доставки, нужна для статистики
     *
     * @property MailDelivery $delivery
     */
    public $delivery;

    /**
     * Возвращает заголовок письма
     *
     * @return string
     */
    abstract public function getSubject();

    public function __construct(User $user, $params = array())
    {
        $this->user = $user;
        foreach ($params as $k => $v)
            $this->$k = $v;

        $this->delivery = $this->createDelivery();
        $this->token = $this->createToken();
        $this->bodyHtml = $this->render($this->getTemplateFile(), array(), true);
    }

    /**
     * Возвращает тело письма
     *
     * @return string
     */
    public function getBody()
    {
        return $this->bodyHtml;
    }

    /**
     * Возвращает заголовок, находящийся в теле письма
     *
     * @return string
     */
    public function getTitle()
    {
        return 'Здравствуйте, ' . $this->user->first_name . '!';
    }

    /**
     * Генерирует ссылки, используется главным образом внутри шаблонов
     *
     * @param $url
     * @param null $utmContent
     * @return string
     * @throws CException
     */
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
        $url = $this->addRedirect($this->addUtmTags($url, $utmContent));
        return $url;
    }

    /**
     * Рендерит файл шаблона, находящийся в tpl
     *
     * @param $file
     * @param array $data
     * @param bool $return
     * @return mixed
     */
    public function render($file, $data = array(), $return = false)
    {
        /**
         * @var CConsoleApplication $app
         */
        $app = Yii::app();
        $data['message'] = $this;
        $runner = $app instanceof CConsoleApplication ? $app->getCommandRunner()->getCommand() : $app->controller;
        $output = $runner->renderFile($this->getTemplateInternal($file), $data, true);
        if ($return) {
            return $output;
        } else {
            echo $output;
        }
    }

    /**
     * Подменяет оригинальную ссылку на промежуточную, необходимую для подсчета статистики и авторизации
     *
     * @param $url
     * @return string
     */
    protected function addRedirect($url)
    {
        return Yii::app()->createAbsoluteUrl('/mail/default/redirect', array('redirectUrl' => urlencode($url), 'tokenHash' => $this->token->hash, 'deliveryHash' => $this->delivery->hash));
    }

    /**
     * Добавляет UTM-теги
     *
     * @param $url
     * @param $utmContent
     * @return string
     */
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
        $glue = (strpos($url, '?') === false) ? '?' : '&';
        $hashSymbolPos = strpos($url, '#');

        if ($hashSymbolPos === false) {
            return $url . $glue . $utmString;
        } else {
            return substr_replace($url, $glue . $utmString, $hashSymbolPos, 0);
        }
    }

    /**
     * Генерирует аутентификационный токен для письма
     *
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

    /**
     * Генерирует модель доставки
     *
     * @return MailDelivery
     */
    protected function createDelivery()
    {
        $delivery = new MailDelivery();
        $delivery->user_id = $this->user->id;
        $delivery->type = $this->type;
        $delivery->hash = $this->getUniqueHash();
        $delivery->save();
        return $delivery;
    }

    /**
     * Генерирует уникальный хеш
     *
     * @return string
     */
    protected function getUniqueHash()
    {
        return md5(uniqid($this->user->id, true));
    }

    /**
     * Возвращает срок жизни аутентификационного токена
     *
     * @return int
     */
    protected function getTokenLifetime()
    {
        return 48 * 60 * 60;
    }

    /**
     * Возвращает файл, который будет использован для рендеринга письма
     *
     * @return string
     */
    protected function getTemplateFile()
    {
        return $this->type;
    }

    /**
     * Возвращает путь к конкретному файлу в папке шаблонов
     *
     * @param $file
     * @return string
     */
    protected function getTemplateInternal($file)
    {
        return $this->getTemplatesPath() . DIRECTORY_SEPARATOR . $file . '.php';
    }

    /**
     * Возвращает путь к папке шаблонов
     *
     * @return mixed
     */
    protected function getTemplatesPath()
    {
        return Yii::getPathOfAlias('site.frontend.modules.mail.tpls');
    }
}