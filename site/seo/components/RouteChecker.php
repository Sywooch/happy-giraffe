<?php
/**
 * Author: alexk984
 * Date: 30.01.13
 */
class RouteChecker
{
    public $keywords = array(
        'расстояние A B',
        'расстояние между A2 и B2',
        'A B на машине',
        'A B расстояние на машине',

        'сколько от A3 до B3',
        'км A B',
        'A B сколько км',
        'A B сколько километров',
        'от A3 до B3 км',
        'от A3 до B3 километров',
        'A B как доехать',

        'A B на авто',
        'A B на автомобиле',

        'автодорога A B',
        'дорога от A3 до B3',

        'автотрасса A B',
        'трасса A B',
        'трасса A B отзывы',
        'трасса A B состояние',
        'трасса A B карта',
        'схема трассы A B',

        'A B шоссе',
        'магистраль A B',
        'путь A B',
        'A B маршрут',
        'проложить маршрут A B',
        'карта A B',
        'A B сколько ехать',
        'поездка в A из B3',
        'пробки A из B3',
    );

    public $city = array('волгоград', 'волгоградом', 'волгограда');

    public $cities = array(
        array('москва', 'москвой', 'москвы'),
        array('ростов', 'ростовом', 'ростова'),
        array('саратов', 'саратовом', 'саратова'),
        array('астрахань', 'астраханью', 'астрахани'),
        array('краснодар', 'краснодаром', 'краснодара'),
        array('воронеж', 'воронежом', 'воронежа'),
        array('самара', 'самарой', 'самары'),
        array('нижний новгород', 'нижним новгородом', 'нижнего новгорода'),
        array('ставрополь', 'ставрополью', 'ставрополи'),
        array('камышин', 'камышином', 'камышина'),
        array('уфа', 'уфой', 'уфы'),
        array('казань', 'казанбю', 'казани'),
        array('екатеринбург', 'екатеринбургом', 'екатеринбурга'),
        array('элиста', 'элистой', 'элисты'),
        array('пенза', 'пензой', 'пензы'),
        array('домбай', 'домбай', 'домбая'),
        array('белгород', 'белгородом', 'белгорода'),
    );

    public function start()
    {
        $parser = new WordstatParser;
        $parser->use_proxy = false;
        $parser->init(false);

        foreach ($this->cities as $city_id => $city)
            foreach ($this->keywords as $keyword_id => $key) {

                if (!$this->exist($city_id, $keyword_id)) {
                    $keyword = $this->getKeyword($key, $city);
                    $value = $parser->getSimpleValue($keyword);

                    $this->save($city_id, $keyword_id, $value);
                    sleep(2);
                }
            }
    }

    public function save($city_id, $keyword_id, $value)
    {
        Yii::app()->db_seo->createCommand()
            ->insert('routes_check', array(
            'city_id' => $city_id,
            'keyword_id' => $keyword_id,
            'value' => $value,
        ));
    }

    public function exist($city_id, $keyword_id)
    {
        $value = Yii::app()->db_seo->createCommand()
            ->select('city_id')
            ->from('routes_check')
            ->where('city_id = ' . $city_id . ' AND keyword_id =' . $keyword_id)
            ->queryScalar();

        return $value !== false;
    }

    public function getValue($city_id, $keyword_id)
    {
        return Yii::app()->db_seo->createCommand()
            ->select('value')
            ->from('routes_check')
            ->where('city_id = ' . $city_id . ' AND keyword_id =' . $keyword_id)
            ->queryScalar();
    }

    public function getKeyword($key, $city)
    {
        $key = str_replace('A3', $this->city[2], $key);
        $key = str_replace('A2', $this->city[1], $key);
        $key = str_replace('A', $this->city[0], $key);

        $key = str_replace('B3', $city[2], $key);
        $key = str_replace('B2', $city[1], $key);
        $key = str_replace('B', $city[0], $key);

        return $key;
    }
}
