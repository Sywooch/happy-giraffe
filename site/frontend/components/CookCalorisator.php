<?php

class CookCalorisator extends CComponent
{

    public $_RecipeIngredients;
    public $RecipeSubstrings;
    public $ingredients;

    public function setRecipeIngredients($string)
    {
        $this->_RecipeIngredients = $string;
        $string = preg_replace('%(\d+)(,)(\d+)%siu', '$1.$3', $string);
        $this->RecipeSubstrings = preg_split('%(\R|,)%mu', $string, -1, PREG_SPLIT_NO_EMPTY);
        $this->parseIngredients();
    }

    public function parseIngredients()
    {
        foreach ($this->RecipeSubstrings as $s) {
            $ingredient = array('text' => trim($s));

            // Seacrh unit

            $units = Yii::app()->search->select('*')->from('cookUnits')->where($this->sphinxQuote($s))->limit(0, 1)->searchRaw();


            if (count($units['words'])) {

                foreach ($units['words'] as $key => $word) {
                    if (!preg_match('%\d+%', $key)) {
                        $ingredient['words'][] = $key;
                        if ($word['docs'] > 0)
                            $ingredient['unit']['words'][] = $key;
                    }
                }
                $ingredient['unit']['words'] = $this->completeWords($ingredient['unit']['words'], $s);
                $ingredient['words'] = $this->completeWords($ingredient['words'], $s);
            }

            if (count($ingredient['unit']['words'])) {
                $unit_seacrh = Yii::app()->search->select('*')->from('cookUnits')->where($this->sphinxQuote(implode(' ', $ingredient['unit']['words'])))->limit(0, 1)->searchRaw();

                if (count($unit_seacrh['matches'])) {
                    $unit_id = key($unit_seacrh['matches']);
                    $unit_id = ($unit_seacrh['matches'][$unit_id]['attrs']['parent_id'] > 0) ? $unit_seacrh['matches'][$unit_id]['attrs']['parent_id'] : $unit_id;
                    $ingredient['unit']['row'] = Yii::app()->db->createCommand()->select('*')->from('cook__units')->where('id=:id', array(':id' => $unit_id))->queryRow();
                }
            }

            // search ingredient

            if (is_array($ingredient['unit']['words']))
                $ingredient['ingredient']['words'] = array_diff($ingredient['words'], $ingredient['unit']['words']);
            if (count($ingredient['ingredient']['words'])) {
                $ingredient_seacrh = Yii::app()->search->select('*')->from('cookIngredients')->where($this->sphinxQuote(implode(' ', $ingredient['ingredient']['words'])))->limit(0, 4)->searchRaw();
                //$ingredient['ingredient']['search'] = $ingredient_seacrh;
                if (count($ingredient_seacrh['matches'])) {
                    $ingredient_id = key($ingredient_seacrh['matches']);
                    $ingredient['ingredient']['row'] = Yii::app()->db->createCommand()->select('*')->from('cook__ingredients')->where('id=:id', array(':id' => $ingredient_id))->queryRow();
                }
            }

            // search Qty

            $text = $s;
            foreach ($ingredient['words'] as $word) {
                $text = preg_replace('%' . preg_quote($word, '%') . '%siu', '', $text);
            }

            if (preg_match('%(\d+)%', $text, $m))
                $ingredient['qty'] = $m[1];
            if (preg_match('%([0-9\.]+)%', $text, $m))
                $ingredient['qty'] = $m[1];
            if (preg_match('%(\d+)/(\d+)%', $text, $m))
                $ingredient['qty'] = $m[1] / $m[2];
            if (preg_match('%(\d+)\s+(\d+)/(\d+)%', $text, $m))
                $ingredient['qty'] = $m[1] + $m[2] / $m[3];
            if (preg_match('%(\d+)(-|—)(\d+)%', $text, $m))
                $ingredient['qty'] = ($m[1] + $m[3]) / 2;

            $this->ingredients[] = $ingredient;
        }
    }

    private function sphinxQuote($string)
    {
        $from = array('\\', '(', ')', '|', '-', '!', '@', '~', '"', '&', '/', '^', '$', '=');
        $to = array('\\\\', '\(', '\)', '\|', '\-', '\!', '\@', '\~', '\"', '\&', '\/', '\^', '\$', '\=');
        return str_replace($from, $to, $string);
    }

    private function completeWords($words, $string)
    {
        if (!count($words))
            return $words;
        foreach ($words as $word) {
            preg_match('%(\s|^)+(' . preg_quote($word, '%') . '.{0,3}?)(\s|$)+%siu', $string, $m);
            $result[] = $m[2];
        }
        return $result;
    }


}