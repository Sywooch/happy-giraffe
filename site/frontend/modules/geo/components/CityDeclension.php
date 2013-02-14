<?php
/**
 * Author: alexk984
 * Date: 11.02.13
 */
class CityDeclension
{
    private $rules = array(
        'ово' => array('ово', 'ово'),
        'ево' => array('ево', 'ево'),
        'ино' => array('ино', 'ино'),
        'ыно' => array('ыно', 'ыно'),
        'нь' => array('ни', 'нью'),
        'ль' => array('ля', 'лем'),
        'ов' => array('ова', 'вом'),
        'ем' => array('ема', 'емом'),
        'ин' => array('ина', 'ином'),
        'жа' => array('жи', 'жей'),
        'ша' => array('ши', 'шей'),
        'ца' => array('цы', 'цей'),
        'га' => array('ги', 'гой'),
        'и' => array('и', 'и'),
        'ы' => array('', 'ами'),
        'ка' => array('ки', 'кой'),
        'а' => array('ы', 'ой'),
        'я' => array('и', 'ей'),
        'ч' => array('ча', 'чем'),
        'ж' => array('жа', 'жем'),
        'ш' => array('ша', 'шем'),
        'щ' => array('ща', 'щем'),
        'ц' => array('ца', 'цем'),
        'б' => array('ба', 'бом'),
        'в' => array('ва', 'вом'),
        'г' => array('га', 'гом'),
        'д' => array('да', 'дом'),
        'з' => array('за', 'зом'),
        'к' => array('ка', 'ком'),
        'л' => array('ла', 'лом'),
        'м' => array('ма', 'мом'),
        'н' => array('на', 'ном'),
        'п' => array('па', 'пом'),
        'р' => array('ра', 'ром'),
        'с' => array('са', 'сом'),
        'т' => array('та', 'том'),
        'ф' => array('фа', 'фом'),
        'х' => array('ха', 'хом'),
        'о' => array('о', 'о'),
        'е' => array('е', 'е'),
    );

    private $words = array(
        'Верхняя '=>array('Верхней ', 'Верхней '),
        'Верхний '=>array('Верхнего ', 'Верхним '),
        'Верхние '=>array('Верхних ', 'Верхними '),
        'Нижняя '=>array('Нижней ', 'Нижней '),
        'Нижний '=>array('Нижнего ', 'Нижним '),
        'Нижние '=>array('Нижних ', 'Нижними '),
        'Новая '=>array('Новой ', 'Новой '),
        'Новый '=>array('Нового ', 'Новым '),
        'Новые '=>array('Новых ', 'Новыми '),
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

                foreach ($this->words as $word => $vals)
                    if (strpos($name, $word) !== false){
                        $n1 = str_replace($word, $vals[0], $n1);
                        $n2 = str_replace($word, $vals[1], $n2);
                    }

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
