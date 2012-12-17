<?php
/**
 * Author: choo
 * Date: 18.07.2012
 */
class SimpleRecipe extends CookRecipe
{
    public $section = 0;

    public $types = array(
        0 => 'Все рецепты',
        1 => 'Первые блюда',
        2 => 'Вторые блюда',
        3 => 'Салаты',
        4 => 'Закуски и бутерброды',
        5 => 'Сладкая выпечка',
        6 => 'Несладкая выпечка',
        7 => 'Торты и пирожные',
        8 => 'Десерты',
        9 => 'Напитки',
        10 => 'Соусы и кремы',
        11 => 'Консервация',
    );

    public function defaultScope()
    {
        return array(
            'condition' => 'section = 0',
        );
    }

    public function getCounts()
    {
        $_counts = array();

        foreach ($this->types as $k => $v)
            $_counts[$k] = 0;

        $counts = Yii::app()->db->createCommand()
            ->select('type, count(*)')
            ->from($this->tableName())
            ->group('type')
            ->where('section = 0 AND removed = 0')
            ->queryAll();

        foreach ($counts as $c){
            $_counts[$c['type']] = $c['count(*)'];
            $_counts[0] += $c['count(*)'];
        }

        return $_counts;
    }
}
