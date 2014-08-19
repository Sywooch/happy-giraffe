<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 08/08/14
 * Time: 14:10
 */

class AlphabetWidget extends CWidget
{
    public function run()
    {
        $letters = Route::getRoutesLetters();
        $this->render('AlphabetWidget', compact('letters'));
    }
} 