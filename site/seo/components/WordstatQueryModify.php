<?php
/**
 * Author: alexk984
 * Date: 11.03.13
 */
class WordstatQueryModify
{
    private $parts = array('я', 'меня', 'мне', 'мной', 'мое', 'моё', 'ты', 'тебя', 'тебе', 'тобой', 'вы', 'вас', 'вам',
        'вами', 'ваш', 'вашим', 'вашу', 'он', 'его', 'им', 'она', 'её', 'ей', 'оно', 'ему', 'мы', 'нас', 'нам', 'нами',
        'они', 'их', 'ими', 'свои', 'кто', 'что', 'который', 'которые', 'которая', 'которое', 'которого', 'которому',
        'которым', 'этот', 'тот', 'такой', 'это', 'весь', 'сам', 'самим', 'самому', 'а', 'б', 'бы', 'вот', 'всё', 'да',
        'ещё', 'ж', 'же', 'и', 'или', 'не', 'нет', 'ну', 'так', 'только', 'уже', 'чтобы', 'в', 'во', 'без', 'до', 'за',
        'к', 'на', 'по', 'о', 'от', 'при', 'с', 'у', 'над', 'об', 'для', 'про', 'из', 'как', 'но', 'то', 'если',
        'когда', 'один', 'одного', 'одно', 'одному', 'одних', 'нашим', 'наших');

    private $new_parts = array();

    /*public function convert()
    {
        $p = explode("\n", $this->str);
        foreach ($p as $p2) {
            echo "'" . $p2 . "', ";
        }
    }*/

    /*public function checkOnPlus()
    {
        foreach ($this->parts as $part) {
            $t = urlencode($part);
            echo '<a href="http://wordstat.yandex.ru/?cmd=words&page=1&t=' . $t . '&geo=&text_geo=">' . $part . '</a>' . '<br>';
        }
    }*/

    /*public function getPhrases()
    {
        $part = $this->parts[array_rand($this->parts)];
        echo $part.'<br><br>';
        $keywords = Yii::app()->db_keywords->createCommand()
            ->select('name')
            ->from('keywords')
            ->where('name LIKE "' . $part . ' %" OR name LIKE "% ' . $part . '" OR name LIKE "% ' . $part . ' %"')
            ->limit(100)
            ->queryColumn();

        foreach($keywords as $keyword)
            echo $this->prepareQuery($keyword).'<br>';
    }*/

    public function addToParsing()
    {
        foreach ($this->parts as $num => $part) {
            if (empty($part) || $num < 0)
                continue;

            echo "$num - selecting records\n";
            $ids = Yii::app()->db_keywords->createCommand()
                ->select('id')
                ->from('keywords')
            //вначале фразы, вконце фразы, в середине фразы
                ->where('name LIKE "' . $part . ' %" OR name LIKE "% ' . $part . '" OR name LIKE "% ' . $part . ' %"')
                ->queryColumn();
            echo count($ids) . "\n";

            $i=0;
            foreach ($ids as $id) {
                //добавляем на перепарсинг с большим приоритетом
                $parsing = ParsingKeyword::model()->findByPk($id);
                if ($parsing === null) {
                    $parsing = new ParsingKeyword;
                    $parsing->keyword_id = $id;
                    $parsing->priority = 2;
                } else{
                    $parsing->priority = 2;
                    $parsing->updated = '0000-00-00 00:00:00';
                }

                try {
                    $parsing->save();
                } catch (Exception $e) {
                }

                if ($i % 50000)
                    echo '50 000 done'."\n";
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

    private function startsWith($haystack, $needle)
    {
        return !strncmp($haystack, $needle, strlen($needle));
    }

    private function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    /**
     * Проверяем фразу из wordstat в которой есть +
     * Ищем слова перед которыми надо ставить +
     */
    public function analyzeQuery($q)
    {
        preg_match_all('/\+([^\s]+)/', $q, $matches);
        for ($i = 0; $i < count($matches[0]); $i++) {
            $p = $matches[1][$i];
            if (!in_array($p, $this->parts) && !in_array($p, $this->new_parts)){
                //echo $p . '<br>';
                $this->new_parts [] = $p;
                $fh = fopen($dir = Yii::getPathOfAlias('application.runtime') . DIRECTORY_SEPARATOR . 'predlogi.txt', 'a');
                fwrite($fh, $p . "\n");
            }
        }
    }
}
