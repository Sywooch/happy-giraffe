<?php
/**
 * Author: choo
 * Date: 18.07.2012
 */
class MultivarkaRecipe extends CookRecipe
{
    public $section = 1;

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
        12 => 'Блюда из молочных продуктов',
        13 => 'Рецепты для малышей',
        14 => 'Рецепты-дуэты',
    );

    public function defaultScope()
    {
        return array(
            'condition' => 'section = 1',
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
            ->where('section = 1 AND removed = 0')
            ->queryAll();

        foreach ($counts as $c){
            $_counts[$c['type']] = $c['count(*)'];
            $_counts[0] += $c['count(*)'];
        }

        return $_counts;
    }
}
