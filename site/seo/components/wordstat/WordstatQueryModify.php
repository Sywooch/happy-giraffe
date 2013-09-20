<?php
/**
 * Class WordstatQueryModify
 *
 * Добавление + перед предлогами к ключевому слову, для более корректного парсинга wordstat
 *
 * работа у меня => работа +у +меня
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class WordstatQueryModify
{
    private $parts = array('я', 'меня', 'мне', 'мной', 'мое', 'моё', 'ты', 'тебя', 'тебе', 'тобой', 'вы', 'вас', 'вам', //12
        'вами', 'ваш', 'вашим', 'вашу', 'он', 'его', 'им', 'она', 'её', 'ей', 'оно', 'ему', 'мы', 'нас', 'нам', 'нами', //28
        'они', 'их', 'ими', 'свои', 'кто', 'что', 'который', 'которые', 'которая', 'которое', 'которого', 'которому', //40
        'которым', 'этот', 'тот', 'такой', 'это', 'весь', 'сам', 'самим', 'самому', 'а', 'б', 'бы', 'вот', 'всё', 'да', //55
        'ещё', 'ж', 'же', 'и', 'или', 'не', 'нет', 'ну', 'так', 'только', 'уже', 'чтобы', 'в', 'во', 'без', 'до', 'за', //72
        'к', 'на', 'по', 'о', 'от', 'при', 'с', 'у', 'над', 'об', 'для', 'про', 'из', 'как', 'но', 'то', 'если', //89
        'когда', 'один', 'одного', 'одно', 'одному', 'одних', 'нашим', 'наших', //97

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
        'свій', 'такий', 'лише', 'твоїм', 'моею', 'моём', 'буде', 'моїй', 'є', 'or', 'with', 'самих', 'вашого',
        'всього', 'своём', 'усе', 'саму', 'at', 'as', 'тую', 'моими', 'can', 'мене', 'самими', 'могло', 'хіба', 'цей',
        'якщо', 'можем', 'сими', 'якої', 'мого', 'сю', 'немов', 'нехай', 'він', 'неї', 'моє', 'під', 'мочь', 'any',
        'самою', 'have', 'нашої', 'їх', 'його', 'усі', 'такі', 'всім', 'an', 'would', 'but', 'їхня', 'якого', 'чий',
        'нашими', 'будуть', 'майже', 'чим', 'або', 'яких', 'були', 'самий', 'яке', 'хоч', 'тими', 'самі', 'будеш',
        'свої', 'таку', 'вже', 'ще', 'нашого', 'всьому', 'этими', 'нею', 'було', 'моєї', 'наші', 'їхні', 'чомусь',
        'which', 'їм', 'моєму', 'нашому', 'цьому', 'своїх', 'невже', 'саме', 'між', 'одною', 'ніхто', 'ся', 'сі',
        'they', 'своїй', 'навіть', 'будемо', 'кім', 'чия', 'чиє', 'чиїх', 'своєї', 'моїм', 'нём', 'будьмо', 'нашею',
        'усього', 'твоє', 'своєму', 'одними', 'всіх', 'усієї', 'моїх', 'оці', 'твої', 'усіх', 'їй', 'поки', 'нашім',
        'вашому', 'якусь', 'отак', 'тою', 'твого', 'моги', 'твоїх', 'усім', 'теє', 'якими', 'ці', 'наче', 'твоєї',
        'усьому', 'своїм', 'щось', 'сій', 'ніщо', 'нічим', 'ніби', 'усіма', 'цим', 'когось', 'нім', 'нього',
        'між',
    );

    private $new_parts = array();

    public function convert()
    {
        $array = file('C:/WebServers/hg_files/predlogi.txt');
        $array = array_unique($array);
        foreach ($array as $p) {
            echo "'" . trim($p) . "', ";
        }
    }

    public function addToParsing($index)
    {
        $parts = array(
            array("(", 1),
            array(")", 1),
            array("'", 1),
        );

        $part = $parts[$index][0];
        echo $part."\n";
        $criteria = new CDbCriteria;
        $criteria->params = array(':part' => '%' . $part . '%');
        for ($i = $parts[$index][1]; $i < 550; $i++) {
            $criteria->condition = 'name LIKE :part AND id >= ' . ($i * 1000000) . ' AND id < ' . (($i + 1) * 1000000);
            $keywords = Keyword::model()->findAll($criteria);
            if (!empty($keywords))
                echo $i . '-' . count($keywords) . "\n";

            foreach ($keywords as $keyword) {
                $name = $this->prepareForSave($keyword->name);

                $keyword->name = $name;
                $exist = Keyword::model()->findByAttributes(array('name' => $name));
                if ($exist === null)
                    $keyword->update(array('name'));
                else
                    $keyword->delete();
            }
        }
    }

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
        $q = $this->prepareForSave($q);

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

    /**
     * Подготовим запрос для получения значения поискового трафика по точному совпадению фразы
     * вид результата - "!word !word"
     * @param $q string
     * @return string
     */
    public function prepareStrictQuery($q)
    {
        $q = $this->prepareForSave($q);

        //вставляем !
        //если вначале
        $words = explode(' ', $q);
        $result_words = array();
        foreach ($words as $word) {
            $result_words [] = '!' . $word;
        }

        return '"' . implode(' ', $result_words) . '"';
    }

    /**
     * Подготовим запрос для получения значения поискового трафика по неточному совпадению фразы (в кавычках)
     * вид результата - "word word"
     * @param $q
     * @return string
     */
    public function prepareQuotesQuery($q)
    {
        $q = $this->prepareForSave($q);

        return '"' . $q . '"';
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

    public static function prepareForSave($name)
    {
        $name = mb_strtolower($name, 'utf-8');
        $parts = array(',', '"', '?', '!', ':', ';', "\\", '/', '-', '+', '|', ')', '(', '\'');

        foreach ($parts as $part)
            $name = str_replace($part, ' ', $name);

        $name = str_replace(' . ', ' ', $name);
        $name = str_replace('. ', ' ', $name);
        $name = str_replace(' .', ' ', $name);

        $name = trim($name);
        $name = trim($name, '.');
        while (strpos($name, '  ') !== false)
            $name = str_replace('  ', ' ', $name);

        return $name;
    }
}
