<?php

namespace site\common\helpers;

/**
 * Компонент, позволяющий выполнять проверку на уникальность, с использованием внутренних исключений
 *
 * @author Кирилл
 */
class UniquenessChecker extends \CComponent
{

    /**
     * Метод, проверяющий индекс уникальности по автору и тексту
     * 
     * @param int|User $author id или модель пользователя
     * @param string $text Текст, проверяемый на уникальность
     * @return int|null Уникальность от 0 до 100, если -1,
     * то проверка не производилась,
     * из-за исключений (длина текста меньше 250 или пользователь в списке исключений).
     * Может вернуть null, если сервис проверки недоступен
     */
    public static function complexTest($author, $text)
    {
        return self::checkBeforeTest($author, $text) ? CopyScape::getUniquenessByText($text) : -1;
    }

    /**
     * Метод, проверяющий пользователя в списке исключений. В списке исключений те пользователи,
     * чей контент всегда должен быть в noindex
     * 
     * @param User|int $author id или модель пользователя
     * @return bool true - если пользователь есть в списке исключений, иначе - false
     */
    public static function checkNoindexByUser($author)
    {
        $authorId = $author instanceof \User ? $author->id : (int) $author;
        return in_array($authorId, array(
            34531,
        ));
    }

    /**
     * Метод, проверяющий, стоит ли проверять уникальность через сервис
     * Проверяет длину и наличие пользователя в списке исключений
     * 
     * @param type $author
     * @param type $text
     * @return bool true - если требуется проверка, иначе - false
     */
    public static function checkBeforeTest($author, $text)
    {
        return !self::checkNoindexByUser($author) && strlen($text) > 250;
    }

}

?>
