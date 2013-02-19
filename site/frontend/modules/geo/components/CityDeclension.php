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
        'вь' => array('ви', 'вью'),
        'ов' => array('ова', 'овом'),
        'ем' => array('ема', 'емом'),
        'ин' => array('ина', 'ином'),
        'жа' => array('жи', 'жей'),
        'ша' => array('ши', 'шей'),
        'ца' => array('цы', 'цей'),
        'га' => array('ги', 'гой'),
        'ка' => array('ки', 'кой'),

        'ый' => array('ого', 'ым'),
        'ай' => array('ая', 'ем'),
        'ая' => array('ой', 'ой'),
        'ий' => array('ого', 'им'),
        'чь' => array('чи', 'чью'),
        'ей' => array('ея', 'еем'),
        'ха' => array('хи', 'хой'),
        'нок' => array('нка', 'нком'),
        'уй' => array('уя', 'уем'),
        'ец' => array('ца', 'цем'),

        'бой' => array('боя', 'боем'),
        'вой' => array('воя', 'воем'),
        'гой' => array('гоя', 'гоем'),
        'дой' => array('доя', 'доем'),
        'лой' => array('лоя', 'лоем'),
        'мой' => array('моя', 'моем'),
        'рой' => array('роя', 'роем'),

        'кой' => array('кого', 'коем'),
        'пой' => array('пого', 'поем'),
        'сой' => array('сого', 'соем'),
        'той' => array('того', 'тоем'),
        'фой' => array('фого', 'фоем'),
        'хой' => array('хого', 'хоем'),
        'ной' => array('ного', 'ноем'),

        'и' => array('и', 'и'),
        'ы' => array('', 'ами'),
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

    public static function go()
    {
        $model = new CityDeclension();

        $cities = GeoCity::model()->findAll('type="г"');
        foreach ($cities as $city) {
            list($n1, $n2) = $model->getDeclensions($city->name);
            $city->name_from = $n1;
            $city->name_between = $n2;
            $city->save();
        }
    }

    public function getDeclensions($name)
    {
        $words = explode(' ', $name);
        $n1 = '';
        $n2 = '';

        foreach ($words as $word) {
            $w1 = '';
            $w2 = '';
            foreach ($this->rules as $ends => $rule) {
                if ($this->endsWith($word, $ends)) {
                    $w1 = substr($word, 0, strlen($word) - strlen($ends)) . $rule[0];
                    $w2 = substr($word, 0, strlen($word) - strlen($ends)) . $rule[1];
                    break;
                }
            }
            if (empty($w1)) $w1 = $word;
            if (empty($w2)) $w2 = $word;

            $n1 .= $w1.' ';
            $n2 .= $w2.' ';
        }

        return array(trim($n1), trim($n2));
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
