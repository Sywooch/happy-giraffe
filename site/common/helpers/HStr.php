<?php

namespace site\common\helpers;

/**
 * Description of HStr
 *
 * @author Кирилл
 */
class HStr extends \CComponent {

    /**
     * обрезание строки с сохранением некоторых тэгов
     * @param string $string
     * @param int $length
     * @param string $etc
     * @param bool $breakWords
     * @return string 
     * @author crocodile
     */
    public static function trancateHTML1V($string, $length = 80, $etc = '...', $breakWords = false) {
        /* используем библиотеку Qevix для правильной обрезки html */
        $qevix = new \site\frontend\components\Qevix();
        $qevix->cfgAllowTags(array('br', 'p', 'b', 'strong', 'i', 'u', 'ul', 'li', 'ol', 'strike', 'a', 'img'));
        $qevix->cfgSetTagShort(array('br', 'img'));
        $qevix->cfgSetTagNoAutoBr(array('ul', 'ol'));
        $qevix->cfgSetTagCutWithContent(array('script', 'object', 'iframe', 'style', 'img'));
        $qevix->cfgSetTagChilds('ul', 'li', true, true);
        $qevix->cfgSetTagChilds('ol', 'li', true, true);

        $e = null;
        $returnStr = $qevix->parse($string, $e);
        /* из за странного бага img с параметрами обрабатывается не корректно, поэтому
         * сперва разрешаем этот тэг и у него удаляются параметры, потом еще раз
         * обрбатываем текс и у него удаляются img */
        $qevix->cfgAllowTags(array('br', 'p', 'b', 'strong', 'i', 'u', 'ul', 'li', 'ol', 'strike', 'a'));
        $qevix->cfgSetTagShort(array('br'));
        $returnStr = $qevix->parse($string, $e);
        /* обрезаетм текс */
        if (mb_strlen($returnStr, 'UTF-8') > $length) {
            if (!$breakWords) {
                // Обрежем на один символ больше
                $returnStr = mb_substr($returnStr, 0, $length + 1, 'UTF-8');
                // Удалим последнее слово и символы не образующие слово. Т.к. мы обрезали на один символ больше, то последние символы составляющие слово требуется вырезать.
                $returnStr = preg_replace('~\W*\w*$~u', '', $returnStr);
            } else {
                $returnStr = mb_substr($returnStr, 0, $length, 'UTF-8');
            }
            /* удаляем последний тэг, если на нём произошло обрезание */
            $p1 = mb_strripos($returnStr, '>');
            $p2 = mb_strripos($returnStr, '<');
            if ($p2 > $p1) {
                $returnStr = mb_substr($returnStr, 0, $p2 - 1, 'UTF-8');
            }
            $returnStr .= $etc;
        }


        return $returnStr;
    }

    /**
     * 
     * @param type $string Строка, которую надо обрезать
     * @param type $length Определяет максимальную длину обрезаемой строки
     * @param type $etc Текстовая строка, которая заменяет обрезаемый текст. Её длина НЕ включена в максимальную длину обрезаемой строки
     * @param type $breakWords Определяет, обрезать ли строку в промежутке между словами (false) или строго на указанной длине (true)
     * @return type
     */
    public static function truncate($string, $length = 80, $etc = '...', $breakWords = false) {
        $result = $string;
        if (mb_strlen($string, 'UTF-8') > $length) {
            if (!$breakWords) {
                // Обрежем на один символ больше
                $result = mb_substr($result, 0, $length + 1, 'UTF-8');
                // Удалим последнее слово и символы не образующие слово. Т.к. мы обрезали на один символ больше, то последние символы составляющие слово требуется вырезать.
                $result = preg_replace('~\W*\w*$~u', '', $result);
            } else {
                $result = mb_substr($result, 0, $length, 'UTF-8');
            }
            $result .= $etc;
        }

        return $result;
    }

    public static function strToParagraph($str) {
        return '<p>' . str_replace("\n", '</p><p>', $str) . '</p>';
    }

}

?>
