<?php
class Str
{
    /**
     * Метод для обрезания строк.
     * Взят из плагинов "Smarty 3.0.6"
     * + добавлен параметр "$charset" (Иначе косяки с кириллицей в utf-8)
     * + подправлен код, т.к. неверно обрезались строки до целых слов
     *
     * $string - Строка, которую надо обрезать
     *
     * $length - Определяет максимальную длину обрезаемой строки
     *
     * $etc - Текстовая строка, которая заменяет обрезаемый текст.
     * Её длина НЕ включена в максимальную длину обрезаемой строки.
     *
     * $break_words - Определяет, обрезать ли строку в промежутке между словами (false)
     * или строго на указанной длине (true).
     *
     * $middle - Определяет, нужно ли обрезать строку в конце (false) или в середине строки (true).
     * Обратите внимание, что при включении этой опции, промежутки между словами игнорируются.
     *
     * $exact_length - Если true, то обрезается точно по запрашиваемой длине + $etc, если false, то запрашиваемая длина - длина $etc + $etc
     *
     * $charset - Кодировка строки
     *
     * @param string $string
     * @param integer $length
     * @param string $etc
     * @param boolean $break_words
     * @param boolean $middle
     * @param string $charset
     * @return string
     *
     * @version 0.1 21.08.2011
     * @since 0.1
     * @author webmaxx <webmaxx@webmaxx.name>
     */
    public static function truncate($string, $length = 80, $etc = '...', $break_words = false, $middle = false, $exact_length = true, $charset = 'UTF-8')
    {
        if ($length == 0) return '';

        if (!function_exists('mb_strlen')) {
            if (mb_detect_encoding($string, 'UTF-8, ISO-8859-1') === 'UTF-8') {
                // $string has utf-8 encoding
                if (mb_strlen($string, $charset) > $length) {
                    if (!$break_words && !$middle) {
                        $string = mb_ereg_replace('/\s+?(\S+)?$/u', '', mb_substr($string, 0, $length + 1, $charset));

                        if (mb_strlen($string, $charset) > $length)
                            return preg_replace('/\s+?(\S+)?$/u', '', $string) . $etc;

                    }

                    if (!$exact_length) $length -= min($length, mb_strlen($etc, $charset));

                    if (!$middle)
                        return mb_substr($string, 0, $length, $charset) . $etc;
                    else
                        return mb_substr($string, 0, $length / 2, $charset) . $etc . mb_substr($string, -$length / 2, $charset);

                } else {
                    return $string;
                }
            }
        }

        // $string has no utf-8 encoding
        if (strlen($string) > $length) {
            if (!$break_words && !$middle) {
                $string = preg_replace('/\s+?(\S+)?$/', '', substr($string, 0, $length + 1));

                if (mb_strlen($string, $charset) > $length)
                    return preg_replace('/\s+?(\S+)?$/', '', $string) . $etc;
            }

            if (!$exact_length) $length -= min($length, strlen($etc));

            if (!$middle)
                return substr($string, 0, $length) . $etc;
            else
                return substr($string, 0, $length / 2) . $etc . substr($string, -$length / 2);
        } else {
            return $string;
        }
    }

    public static function strToParagraph($str)
    {
        return '<p>'.str_replace("\n", '</p><p>', $str).'</p>';
    }

    public static function getDescription($text, $len = 300, $etc = '...')
    {
        $text = strip_tags(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));
        $text = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $text);
        return trim(Str::truncate($text, $len, $etc));
    }

    public static function prepareForSphinxSearch($text)
    {
        $text = preg_replace('/[^a-zа-яё\d\s]+/iu', '', $text);

        return $text;
    }

    /**
     * Формы слов по порядку в массиве (1: день, 2-4:дня, 5-10:дней)
     *
     * @static
     * @param $words
     * @param $number string
     */
    public static function GenerateNoun($words, $number)
    {
        switch ($number) {
            case 11:
                return $words[2];
            case 12:
                return $words[2];
            case 13:
                return $words[2];
            case 14:
                return $words[2];
        }
        if (strstr($number, '.') || strstr($number, ','))
            return $words[2];

        $last_symbol = substr($number, -1);
        switch ($last_symbol) {
            case 1:
                return $words[0];
            case 2:
                return $words[1];
            case 3:
                return $words[1];
            case 4:
                return $words[1];
            case 5:
                return $words[2];
            case 6:
                return $words[2];
            case 7:
                return $words[2];
            case 8:
                return $words[2];
            case 9:
                return $words[2];
            case 0:
                return $words[2];
        }
    }

    public static function htmlTextLength($html)
    {
        return mb_strlen(trim(strip_tags($html, '<p>')),'UTF-8');
    }
}