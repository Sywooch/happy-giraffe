<?php
/**
 * Author: alexk984
 * Date: 11.02.13
 */
class CityDeclension
{
    private $rules = array(
        'и' => array('и', 'и'),
        'ы' => array('', 'ами'),
    );

    public static function go()
    {
        $model = new CityDeclension();

        $cities = GeoCity::model()->findAll('type="г"');
        foreach($cities as $city){
            list($n1, $n2) = $model->getDeclensions($city);
            $city->name_from = $n1;
            $city->name_between = $n2;
            $city->save();
        }
    }

    public function getDeclensions($name)
    {
        foreach($this->rules as $ends => $rule){
            if ($this->endsWith($name, $ends)){
                $n1 = substr($name, 0, strlen($name) - strlen($ends)).$rule[0];
                $n2 = substr($name, 0, strlen($name) - strlen($ends)).$rule[1];

                return array($n1, $n2);
            }
        }

        return array($name, $name);
    }

    private function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }
}
