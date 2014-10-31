<?php

namespace site\common\helpers;

/**
 * Description of HStr
 *
 * @author Кирилл
 */
class HStr extends \CComponent
{

    /**
     * 
     * @param type $string Строка, которую надо обрезать
     * @param type $length Определяет максимальную длину обрезаемой строки
     * @param type $etc Текстовая строка, которая заменяет обрезаемый текст. Её длина НЕ включена в максимальную длину обрезаемой строки
     * @param type $breakWords Определяет, обрезать ли строку в промежутке между словами (false) или строго на указанной длине (true)
     * @return type
     */
    public static function truncate($string, $length = 80, $etc = '...', $breakWords = false)
    {
        $result = $string;
        if (mb_strlen($string, 'UTF-8') > $length) {
            if (!$breakWords) {
                // Обрежем на один символ больше
                $result = mb_substr($result, 0, $length + 1, 'UTF-8');
                // Удалим последнее слово и символы не образующие слово. Т.к. мы обрезали на один символ больше, то последние символы составляющие слово требуется вырезать.
                $result = preg_replace('~\W*\w*$~u', '', $result);
            }
            else {
                $result = mb_substr($result, 0, $length, 'UTF-8');
            }
        }

        return $result;
    }

    public static function strToParagraph($str)
    {
        return '<p>' . str_replace("\n", '</p><p>', $str) . '</p>';
    }

}

?>
