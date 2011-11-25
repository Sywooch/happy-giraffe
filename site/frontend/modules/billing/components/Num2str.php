<?php
class num2str {

	private $rank = array(
		1 => array('рубль', 'рубля', 'рублей'),
		2 => array('тысяча', 'тысячи', 'тысяч'),
		3 => array('миллион', 'миллиона', 'миллионов'),
		4 => array('миллиард', 'миллиарда', 'миллиардов'),
		5 => array('триллион', 'триллиона', 'триллионов')
	);
	private $A0_9 = array(0 => 'ноль', 1 => 'один', 2 => 'два', 3 => 'три', 4 => 'четыре', 5 => 'пять', 6 => 'шесть', 7 => 'семь', 8 => 'восемь', 9 => 'девять');
	private $A0_9_ = array(0 => 'ноль', 1 => 'одна', 2 => 'две', 3 => 'три', 4 => 'четыре', 5 => 'пять', 6 => 'шесть', 7 => 'семь', 8 => 'восемь', 9 => 'девять');
	private $A10_19 = array(10 => 'десять', 11 => 'одиннадцать', 12 => 'двенадцать', 13 => 'тринадцать', 14 => 'четырнадцать', 15 => 'пятнадцать',
		16 => 'шестнадцать', 17 => 'семнадцать', 18 => 'восемнадцать', 19 => 'девятнадцать');
	private $A20_90 = array(2 => 'двадцать', 3 => 'тридцать', 4 => 'сорок', 5 => 'пятьдесят', 6 => 'шестьдесят', 7 => 'семьдесят', 8 => 'восемьдесят',
		9 => 'девяносто');
	private $A100_900 = array(1 => 'сто', 2 => 'двести', 3 => 'триста', 4 => 'четыреста', 5 => 'пятьсот', 6 => 'шестьсот', 7 => 'семьсот', 8 => 'восемьсот',
		9 => 'девятьсот');
	public $num;
	public $triada;
	public $out;
	public $kop = '';

	public static function doit($v) {
		$num2str = new Num2str($v);
		return $num2str->out;
	}

	function __construct($x) {
		$this->num = $this->prepare($x);
		$this->test();
		$this->rub();
	}

	function prepare($x) {
		$search = array(',', '/');
		$x = str_replace($search, '.', $x);
		$x = explode('.', $x);
		if (empty($x[1])) {
			$this->kop = '00';
		} else {
			$this->kop = $x[1];
		}

		return $x[0];
	}

	function add_null($x) {
		switch ($x) {
			case 0;
				$v = "" . $this->num;
				break;
			case 1:$v = "0" . $this->num;
				break;
			case 2:$v = "00" . $this->num;
				break;
		}
		$this->num = $v;
	}

	function test() {
		$x = mb_strlen($this->num);
		if ($x <= 3) {
			$z = 1;
			$this->add_null(3 - $x);
		} else {
			$y = $x % 3;
			if ($y == 0) {
				$z = $x / 3;
			} else {
				$this->add_null(3 - $y);
				$z = ($x - $y) / 3 + 1;
			}
		}
		return $this->triada = $z;
	}

	private function lexem($x) {
		if ($x == 11 || $x == 12 || $x == 13 || $x == 14) {
			$x = 2;
		} else {
			$x = substr($x, -1);
			if ($x == 1):$x = 0;
			elseif ($x > 1 && $x <= 4):$x = 1;
			else:$x = 2;
			endif;
		}
		return $x;
	}

	function parse($x, $i) {
		$a = substr($x, 0, 1);
		$b = substr($x, 1, 2);
		$c = substr($x, 1, 1);
		$d = substr($x, 2, 1);

		if ($i == 2) {
			$A = $this->A0_9_[$d];
		} else {
			$A = $this->A0_9[$d];
		}
		if ($x == '000' && $i == 1) {
			return $string = ' ' . $this->rank[1][2];
		} else {
			if ($x == '000') {
				return $string = '';
			}
		}
		if ($a >= 1) {
			$string = $this->A100_900[$a];
		}
		if ($b <= 9 && $b != 0) {
			$string.=' ' . $A;
		}
		if ($b <= 19) {
			$string.=' ' . $this->A10_19[$b];
		}
		if ($b >= 20 && $d == 0) {
			$string.=' ' . $this->A20_90[$c];
		}
		if ($b >= 20 && $d != 0) {
			$string.=' ' . $this->A20_90[$c] . ' ' . $A;
		}

		return $string . ' ' . $this->rank[$i][$this->lexem($b)] . ' ';
	}

	function rub() {
		$x = '';
		for ($i = $this->triada; $i > 0; $i--) {
			$x.=$this->parse(substr($this->num, -$i * 3, 3), $i);
		}
		$this->out = ucfirst(trim($x)) . ' ' . $this->kop . ' коп.';
	}

}

/*
class Num2str
{
        public $def = array (
                'form' => array('1' => 0, '2' => 1, '1f' => 0, '2f' => 1, '3' => 1, '4' => 1),
                'rank' => array(
                        0 => array('рубль', 'рубля', 'рублей', 'f' => ''),
                        1 => array('тысяча', 'тысячи', 'тысяч', 'f' => 'f'),
                        2 => array('миллион', 'миллиона', 'миллионов', 'f' => ''),
                        3 => array('миллиард', 'миллиарда', 'миллиардов', 'f' => ''),
                        'k' => array('копейка', 'копейки', 'копеек', 'f' => 'f')
                ),

                'words' => array(
                        '0' => array( '', 'десять', '', ''),
                        '1' => array( 'один', 'одиннадцать', '', 'сто'),
                        '2' => array( 'два', 'двенадцать', 'двадцать', 'двести'),
                        '1f' => array( 'одна', '', '', ''),
                        '2f' => array( 'две', '', '', ''),
                        '3' => array( 'три', 'тринадцать', 'тридцать', 'триста'),
                        '4' => array( 'четыре', 'четырнадцать', 'сорок', 'четыреста'),
                        '5' => array( 'пять', 'пятнадцать', 'пятьдесят', 'пятьсот'),
                        '6' => array( 'шесть', 'шестнадцать', 'шестьдесят', 'шестьсот'),
                        '7' => array( 'семь', 'семнадцать', 'семьдесят', 'семьсот'),
                        '8' => array( 'восемь', 'восемнадцать', 'восемьдесят', 'восемьсот'),
                        '9' => array( 'девять', 'девятнадцать', 'девяносто', 'девятьсот')
                )
        );

        public static function doit($str) {
                $num2str = new Num2str();

                $str = number_format($str, 2, '.', ',');
                $rubkop = explode('.', $str);
                $rub = $rubkop[0];
                $kop = (isset($rubkop[1])) ? $rubkop[1] : '00';
                $rub = (strlen($rub) == 1) ? '0' . $rub : $rub;
                $rub = explode(',', $rub);
                $rub = array_reverse($rub);

                $word = array();
                $word[] = $num2str->dvig($kop, 'k', false);
                        if (intval($value) > 0 || $key == 0) //подсказал skrabus
                                $word[] = $num2str->dvig($value, $key);

                $word = array_reverse($word);
                return ucfirst(trim(implode(' ', $word)));
        }

        public function dvig($str, $key, $do_word = true) {
                $def =& $this->def;
                $words = $def['words'];
                $form = $def['form'];

                if (!isset($def['rank'][$key])) return '!razriad';
                $rank = $def['rank'][$key];
                $sotni = '';
                $word = '';
                $num_word = '';

                $str = (strlen($str) == 1) ? '0' . $str : $str;
                $dig = str_split($str);
                $dig = array_reverse($dig);

                if (1 == $dig[1]) {
                        $num_word = ($do_word) ? $words[$dig[0]][1] : $dig[1] . $dig[0];
                        $word = $rank[2];
                }
                else {
                        //$rank[3] - famale
                        if ($dig[0] != 1 && $dig[0] != 2) $rank['f'] = '';
                        $num_word = ($do_word)
                                ? $words[$dig[1]][2] . ' ' . $words[$dig[0] . $rank['f']][0]
                                : $dig[1] . $dig[0];
                        $key = (isset($form[$dig[0]])) ? $form[$dig[0]] : false;
                        $word = ($key !== false) ? $rank[$key] : $rank[2];
                }

                $sotni = (isset($dig[2])) ? (($do_word) ? $words[$dig[2]][3] : $dig[2]) : '';
                if ($sotni && $do_word) $sotni .= ' ';

                return $sotni . $num_word . ' ' . $word;
        } //function dvig

} //class Num2str()
 *
 */
?>
