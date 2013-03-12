<?php
/**
 * Author: alexk984
 * Date: 11.03.13
 */
class WordstatQueryModify
{
    private $parts = array('я', 'меня', 'мне', 'мной', 'мое', 'моё', 'ты', 'тебя', 'тебе', 'тобой', 'твое', 'твоё',
        'вы', 'вас', 'вам', 'вами', 'ваш', 'вашего', 'вашим', 'ваши', 'вашу', 'он', 'его', 'ему', 'им', 'она',
        'её', 'ей', 'оно', 'его', 'ему', 'мы', 'нас', 'нам', 'нами', 'они', 'их', 'ими', 'твои', 'твоих', 'твоим',
        'свои', 'кто', 'что', 'который', 'которые', 'которая', 'которое', 'которого', 'которому', 'которым', 'этот',
        'тот', 'такой', 'это', 'весь', 'сам', 'самим', 'самому', 'а', 'б', 'бы', 'ведь', 'вот', 'всё', 'да', 'если',
        'ещё', 'ж', 'же', 'и', 'или', 'как', 'ли', 'не', 'нет', 'ни', 'ну', 'так', 'только', 'уж', 'уже', 'чтоб',
        'чтобы', 'в', 'во', 'без', 'до', 'Из', 'за', 'к', 'на', 'по', 'о', 'от', 'при', 'с', 'у', 'за', 'над', 'об',
        'для', 'про', 'из', 'а', 'и', 'или', 'да', 'чтобы', 'будто', 'как', 'но', 'же', 'то', 'если', 'раз', 'когда',
        'тоже', 'один', 'одного', 'одно', 'одному', 'одних');


    /*public function convert()
    {
        $p = explode("\n", $this->str);
        foreach ($p as $p2) {
            echo "'" . $p2 . "', ";
        }
    }*/

    public function addToParsing()
    {
        foreach ($this->parts as $part) {
            if (empty($part))
                continue;

            $ids = Yii::app()->db_keywords->createCommand()
                ->select('id')
                ->from('keywords')
            //вначале фразы, вконце фразы, в середине фразы
                ->where('name LIKE "' . $part . ' %" OR name LIKE "% ' . $part . '" OR name LIKE "% ' . $part . ' %"')
                ->queryColumn();
            echo count($ids) . "\n";

            foreach ($ids as $id) {
                //добавляем на перепарсинг с большим приоритетом
                $parsing = ParsingKeyword::model()->findByPk($id);
                if ($parsing === null) {
                    $parsing = new ParsingKeyword;
                    $parsing->keyword_id = $id;
                    $parsing->priority = 2;
                } else
                    $parsing->updated = '0000-00-00 00:00:00';

                try {
                    $parsing->save();
                } catch (Exception $e) {
                }
            }
        }
    }

    /**
     * Подготовить запрос для ввода на парсинг wordstat
     *
     * @param string $q
     * @return string
     */
    public function prepareQuery($q)
    {
        $q = trim($q);

        if (strpos($q, '+') !== false)
            $q = str_replace('+', ' + ', $q);
        while (strpos($q, '  ') !== false)
            $q = str_replace('  ', ' ', $q);

        $q = str_replace('!', '', $q);

        foreach ($this->parts as $part) {
            if (empty($part))
                continue;

            //если вначале
            if ($this->startsWith($q, $part . ' '))
                $q = '+' . $q;
            //если вконце
            if ($this->endsWith($q, ' ' . $part))
                $q = substr($q, 0, strlen($q) - strlen($part)) . '+' . $part;

            //если в середине
            $q = str_replace(' ' . $part . ' ', ' +' . $part . ' ', $q);
        }

        return $q;
    }

    function startsWith($haystack, $needle)
    {
        return !strncmp($haystack, $needle, strlen($needle));
    }

    function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }
}
