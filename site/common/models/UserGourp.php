<?php
/**
 * Author: alexk984
 * Date: 25.06.12
 */
class UserGourp
{
    const USER = 0;
    const MODERATOR = 1;
    const SMO = 2;
    const EDITOR = 3;
    const ENGINEER = 4;
    const VIRTUAL = 5;

    public static function getName($i){
        switch($i){
            case 0: return 'Пользователи';
            case 1: return 'Модераторы';
            case 2: return 'СМО';
            case 3: return 'Редакция';
            case 4: return 'Тех отдел';
            case 5: return 'Виртуалы';
        }
    }
}
