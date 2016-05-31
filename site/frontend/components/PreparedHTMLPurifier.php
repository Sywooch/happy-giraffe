<?php

namespace site\frontend\components;

/**
 * валидатор HTML на основе YII HTMLPurifier
 */
class PreparedHTMLPurifier
{

    private static $instans = null;
    private static $selfCall = false;

    /**
     *
     * @var \CHtmlPurifier
     */
    private $purifier;

    public function __construct()
    {
        if (!self::$selfCall)
        {
            throw new Exception("mast use getInstans");
        }
//        $config = \HTMLPurifier_Config::createDefault();
//        $config->set('AutoFormat.AutoParagraph', true); // авто добавление <p> в тексте при переносе
//        $config->set('AutoFormat.RemoveEmpty', true); // удаляет пустые теги, есть исключения*
        $this->purifier = new \CHtmlPurifier();
        $this->purifier->options = array(
            'URI.AllowedSchemes' => array('http' => true, 'https' => true),
            'AutoFormat.AutoParagraph' => true,
            //'AutoFormat.RemoveEmpt' => true
        ); // Передача конфига в формате массива
    }

    /**
     * 
     * @return PreparedHTMLPurifier
     */
    public static function getInstans()
    {
        if (self::$instans == null)
        {
            self::$selfCall = true;
            self::$instans = new PreparedHTMLPurifier();
            self::$selfCall = false;
        }
        return self::$instans;
    }

    /**
     * 
     * @param string $html
     * @return string
     */
    public function purifyUserHTML($html)
    {
        return $this->purifier->purify($html);
    }

}
