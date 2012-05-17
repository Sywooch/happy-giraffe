<?php

class TestForm extends HFormModel
{
    public $recipeIngredients;

    public function rules()
    {
        return array(
            array('recipeIngredients', 'required', 'message' => 'Введите ингредиенты')
        );
    }

    public function attributeLabels()
    {
        return array(
            'recipeIngredients' => 'Ингредиенты'
        );
    }


}