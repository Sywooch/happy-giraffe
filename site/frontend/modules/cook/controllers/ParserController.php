<?php

class ParserController extends HController
{
    private $units = array('грамм',
        'грамм',
        'грамма',
        'граммов',
        'килограмм',
        'килограмма',
        'килограммов',
        'шт',
        'столовая ложка',
        'столовые ложки',
        'столовых ложек',
        'чайная ложка',
        'чайные ложки',
        'ч ложки',
        'чайных ложек',
        'банка',
        'банки',
        'банок',
        'головка',
        'головки',
        'головок',
        'зубчик',
        'зубчика',
        'зубчиков',
        'кусок',
        'куска',
        'кусков',
        'на кончике ножа',
        'по вкусу',
        'пучок',
        'пучка',
        'пучков',
        'стакан',
        'стакана',
        'стаканов',
        'стебель',
        'стебля',
        'стеблей',
        'щепотка',
        'щепотки',
        'щепоток',
        'л',
        'мл',
        'г', 'кг', 'литр', 'литров', 'литра', 'гр', 'ч.л.', 'ст. л', 'ломтик', 'ломтиков', 'ломтика', 'ст', 'ложки', 'ложка', 'ложек', 'мг', 'штук'
    );

    public function actionIndex()
    {
        set_time_limit(0);
        $results = array();
        $resultsf = array();

        $criteria = new CDbCriteria();
        $criteria->join = 'INNER JOIN community__contents ON t.content_id = community__contents.id';
        $criteria->condition = 'community__contents.rubric_id > 155 AND community__contents.rubric_id < 182';
        //$criteria->limit = 500;

        $posts = CommunityPost::model()->findAll($criteria);

        foreach ($posts as $post) {
            preg_match_all('%<p>(.*?)</p>%siu', $post->text, $matches);
            if (count($matches[1])) {
                foreach ($matches[1] as $p) {
                    $p = strip_tags($p);
                    $u = 0;
                    foreach ($this->units as $unit) {
                        if (preg_match('%([^А-Яа-я]|^)' . preg_quote($unit, '%') . '([^А-Яа-я]|$)%siu', $p)) {
                            $u++;
                        }
                    }
                    if ($u > 0) {
                        foreach ($this->units as $unit) {
                            $p = preg_replace('%([^А-Яа-я]|^)(' . preg_quote($unit, '%') . ')([^А-Яа-я]|$)%siu', '$1###$3', $p);
                        }
                        $substrings = explode('###', $p);
                        foreach ($substrings as $s) {
                            $s = preg_replace('%[^А-Яа-я\s]%siu', '', $s);
                            $s = preg_replace('%\s{2,}%siu', ' ', $s);
                            preg_match_all('%([^\s]+)%siu', $s, $matches2);
                            $s = trim($s);
                            if (count($matches2[1]) > 0 and count($matches2[1]) < 5 and mb_strlen($s) > 4) {
                                //echo '<pre>' . print_r(trim($s), true) . '</pre>';
                                $results[$s] = $s;
                            }
                        }
                    }
                }
            }
            //echo '<pre>' . print_r($matches[1], true) . '</pre>';
        }

        foreach ($results as $r) {
            //$se = preg_replace('%\s|$%siu', '* ', $r);
            $search = Yii::app()->search->select('*')->from('ingredients')->where($r)->limit(0, 4)->searchRaw();
            if ($search['total_found']) {
                unset($results[$r]);
                $resultsf[] = $r;
                //echo '<pre>' . print_r($search, true) . '</pre>';
            } else {
                echo $r . '<br>';
            }
        }

        //echo '<pre>' . print_r($results, true) . '</pre>';
        echo count($results);
        echo '<pre>' . print_r($resultsf, true) . '</pre>';

        Yii::app()->end();
        //$this->render('index', compact('contents'));
    }

    private function sphinxQuote($string)
    {
        $from = array('\\', '(', ')', '|', '-', '!', '@', '~', '"', '&', '/', '^', '$', '=');
        $to = array('\\\\', '\(', '\)', '\|', '\-', '\!', '\@', '\~', '\"', '\&', '\/', '\^', '\$', '\=');
        return str_replace($from, $to, $string);
    }

}