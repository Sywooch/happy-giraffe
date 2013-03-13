<?php
/**
 * Author: alexk984
 * Date: 11.03.13
 */
class WordstatQueryModify
{
    private $parts = array('я', 'меня', 'мне', 'мной', 'мое', 'моё', 'ты', 'тебя', 'тебе', 'тобой', 'вы', 'вас', 'вам', //12
        'вами', 'ваш', 'вашим', 'вашу', 'он', 'его', 'им', 'она', 'её', 'ей', 'оно', 'ему', 'мы', 'нас', 'нам', 'нами', //28
        'они', 'их', 'ими', 'свои', 'кто', 'что', 'который', 'которые', 'которая', 'которое', 'которого', 'которому',
        'которым', 'этот', 'тот', 'такой', 'это', 'весь', 'сам', 'самим', 'самому', 'а', 'б', 'бы', 'вот', 'всё', 'да',
        'ещё', 'ж', 'же', 'и', 'или', 'не', 'нет', 'ну', 'так', 'только', 'уже', 'чтобы', 'в', 'во', 'без', 'до', 'за',
        'к', 'на', 'по', 'о', 'от', 'при', 'с', 'у', 'над', 'об', 'для', 'про', 'из', 'как', 'но', 'то', 'если',
        'когда', 'один', 'одного', 'одно', 'одному', 'одних', 'нашим', 'наших',

        'все', 'чем', 'будет', 'хай', 'you', 'ком', 'no', 'and', 'би', 'in', 'чего', 'of', 'a', 'себе', 'кому', 'моя',
        'ваша', 'мой', 'своими', 'себя', 'one', 'буду', 'by', 'быть', 'был', 'се', 'the', 'наше', 'сама', 'можешь',
        'была', 'такую', 'было', 'том', 'всем', 'которых', 'кем', 'свою', 'твоя', 'if', 'але', 'одна', 'таки', 'будь',
        'мои', 'is', 'могу', 'on', 'be', 'із', 'такое', 'нашего', 'all', 'to', 'этим', 'своих', 'кого', 'такие', 'that',
        'такая', 'эти', 'эту', 'свой', 'де', 'котором', 'своего', 'мною', 'for', 'i', 'еще', 'есть', 'тільки', 'может',
        'тобою', 'not', 'них', 'from', 'it', 'what', 'одну', 'мою', 'будем', 'твою', 'ко', 'одной', 'всего', 'вся', 'наш',
        'ее', 'ту', 'і', 'которой', 'всей', 'таких', 'та', 'своему', 'тем', 'всех', 'могла', 'свое', 'мені', 'my', 'will',
        'собою', 'таком', 'самого', 'эта', 'тая', 'были', 'которую', 'нашу', 'собой', 'ти', 'своей', 'своё', 'него',
        'одни', 'этого', 'моей', 'це', 'сих', 'такого', 'будьте', 'моим', 'этому', 'своим', 'тех', 'нашей', 'з', 'те',
        'этих', 'ваших', 'чему', 'од', 'мог', 'нем', 'бути', 'того', 'таким', 'нашему', 'той', 'нее', 'этой', 'всю',
        'чому', 'ним', 'своя', 'будешь', 'ней', 'щоб', 'сім', 'нему', 'така', 'about', 'як', 'моему', 'яка', 'своє',
        'що', 'этом', 'від', 'могут', 'ваше', 'наша', 'тім', 'всему', 'який', 'теми', 'которыми', 'so', 'своею', 'само',
        'зі', 'нашем', 'її', 'одним', 'моего', 'комусь', 'ото', 'we', 'дуже', 'ними', 'будут', 'чого', 'можете', 'й',
        'всеми', 'якій', 'нашій', 'якому', 'ні', 'яку', 'моих', 'одном', 'якою', 'своем', 'бо', 'яким', 'ті', 'моем',
        'була', 'нікому', 'був', 'was', 'чи', 'наши', 'тому', 'будете', 'ею', 'своїми', 'сей', 'таке', 'чём', 'лиш',
        'хто', 'тобі', 'такою', 'неё', 'такими', 'такому', 'ви', 'цю', 'могли', 'вашими', 'this', 'свого', 'собі',
        'мої', 'ваші', 'воно', 'do', 'мій', 'аж', 'цього', 'твій', 'йому', 'тим', 'there', 'are', 'тих', 'всі', 'які',
        'свій', 'такий', 'лише', 'твоїм', 'моею');

    private $new_parts = array();

    public function convert()
    {
        $array = file('F:/predlogi.txt');
        $array = array_unique($array);
        foreach ($array as $p) {
            echo "'" . trim($p) . "', ";
        }
    }

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

    public function addToParsing($id)
    {
        foreach ($this->parts as $num => $part) {
            if ($num < $id * 50 || $num > ($id + 1) * 50)
                continue;

            if ($num < 44)
                continue;

            //echo "$num - $part \n";

            for ($k = 0; $k < 50; $k++) {
                $ids = Yii::app()->db_keywords->createCommand()
                    ->select('id')
                    ->from('keywords')
                    ->where('id > ' . ($k * 10000000) . ' AND id <= ' . (($k + 1) * 10000000) . '
                    AND (name LIKE "' . $part . ' %" OR name LIKE "% ' . $part . '" OR name LIKE "% ' . $part . ' %")') //вначале фразы, вконце фразы, в середине фразы
                    ->queryColumn();
               // echo count($ids) . "\n";

                if (!empty($ids)) {
                    $sql = 'update parsing_keywords set priority = 2, updated = "0000-00-00 00:00:00"
                                where keyword_id IN (' . implode(',', $ids) . ');';

                    Yii::app()->db_keywords->createCommand($sql)->execute();
                }
            }
        }
    }

    /*public function addToParsing2($id)
    {
        $last_id = $id;
        $t = time();
        while (true) {
            $keywords = Yii::app()->db_keywords->createCommand()
                ->select(array('id', 'name'))
                ->from('keywords')
                ->where('id > ' . $last_id)
                ->limit(10000)
                ->queryAll();

            if (empty($keywords))
                break;

            $ids = array();
            echo (time() - $t)."\n";
            foreach ($keywords as $keyword) {
                if ($this->hasPart($keyword['name'])) {
                    //echo $keyword['name'] . '<br>';
                    $ids [] = $keyword['id'];
                }
            }
            echo (time() - $t)."\n";
            if (count($ids) > 300) {
                $sql = 'update parsing_keywords set priority = 2, updated = "0000-00-00 00:00:00"
                            where keyword_id IN (' . implode(',', $ids) . ');';
                Yii::app()->db_keywords->createCommand($sql)->execute();
            }
            $last_id = $keywords[count($keywords) - 1]['id'];
            echo $last_id."\n";

//            if ($last_id - $id > 50000000)
//                break;

            echo (time() - $t)."\n";

            break;
        }
    }*/

    public function hasPart($q)
    {
        foreach ($this->parts as $num => $part) {
            if ($num < 43)
                continue;

            //если вначале
            if ($this->startsWith($q, $part . ' '))
                return true;

            //если вконце
            if ($this->endsWith($q, ' ' . $part))
                return true;

            //если в середине
            if (strpos($q, ' ' . $part . ' '))
                return true;
        }

        return false;
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
        if (strpos($q, '"') !== false)
            $q = str_replace('"', '', $q);

        while (strpos($q, '  ') !== false)
            $q = str_replace('  ', ' ', $q);

        $q = str_replace('!', '', $q);

        foreach ($this->parts as $part) {
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
            if (!in_array($p, $this->parts) && !in_array($p, $this->new_parts)) {
                //echo $p . '<br>';
                $this->new_parts [] = $p;
                $fh = fopen($dir = Yii::getPathOfAlias('application.runtime') . DIRECTORY_SEPARATOR . 'predlogi.txt', 'a');
                fwrite($fh, $p . "\n");
            }
        }
    }
}
