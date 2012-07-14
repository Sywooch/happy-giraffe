<?php
/**
 * Author: alexk984
 * Date: 25.06.12
 */
class UserGroup
{
    const USER = 0;
    const MODERATOR = 1;
    const SMO = 2;
    const EDITOR = 3;
    const ENGINEER = 4;
    const VIRTUAL = 5;

    public $name = array(
        0=>'Пользователи',
        1=>'Модераторы',
        2=>'СМО',
        3=>'Редакция',
        4=>'Тех отдел',
        5=>'Виртуалы',
    );

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

    public static function getNames()
    {
        $model = new UserGroup;
        return $model->name;
    }
}
