<?php
/**
 * Author: alexk984
 * Date: 11.03.13
 */
class WordstatQueryModify
{
    private $parts = array(
        'на', 'во', 'при', 'по', 'в', 'и', 'до', 'к', 'как', 'что', 'не', 'для',
        'я', 'мое', 'мне', 'меня', 'мной',
        'он', 'его', 'ему', 'него', 'ним', 'оно',
        'она', 'нее', 'ее', 'ней', 'ей',
        'свой', 'свое', 'своё',
        'все', 'всё', '', '', '');

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


        }

        return $q;
    }
}
