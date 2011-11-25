<?php

class v
{
	/**
	 * Возвращает значение определённой через define константы, или $def если значение не определено.
	 * @param mixed $const
	 * @param mixed $def
	 * @return mixed
	 */
	public static function constant($const, $def=null)
	{
		return defined($const) ? constant($const) : $def;
	}

//-------------------------------------------------------------------
//
	public static function iempty($v, $e)
	{
		return isempty($v) ? $e : $v;
	}

//-------------------------------------------------------------------
//
	public static function iif($v, $a, $b=null)
	{
		return empty($v) ? $b : $a;
	}

//-------------------------------------------------------------------
//
	public static function icase($v /* , $eq1,$res1, $eq2,$res2, ... $eqN,$resN, $def */)
	{
		$def = $v;
		if(!(($n = func_num_args()) % 2))
		{
			$def = func_get_arg(--$n);
		}
		for($i = 1; $i < $n; $i+=2)
		{
			$eq = func_get_arg($i);
			if($v == $eq)
				return func_get_arg($i + 1);
		}
		return $def;
	}

//-------------------------------------------------------------------
//
	/* { isempty
	  Определяет является ли значение пустым.
	  Пустым значением считается пустой массив, пустая строка (нулевая длина
	  строки), нулевое числовое значение, null.
	  } */
	public static function isempty($v, $trim=false)
	{
		return is_string($v) ? strlen($trim ? trim($v) : $v) == 0 : empty($v);
	}

//------------------------------------------------------------------------------
//
	public static function at($a, $i)
	{
		$e = array_slice($a, $i, 1);
		return reset($e);
	}

//-------------------------------------------------------------------
	/* {	vars
	  Предоставляет доступ к массиву с заданым путём. Разделитель состовляющих
	  пути задаётся аргументом $s. Если искомый массив не найден он создаётся.

	  Путь $id='a:b:c' с разделителем ':' будет адресоваться к
	  элементу $vars['a']['b']['c'].
	  }
	  public static function &vars($vars, $id=null, $s=':') {
	  $v = &$vars;
	  if ($id) foreach(explode($s, $id) as $id) {
	  if (!isset($v[$id])) $v[$id] = array();
	  $v = &$v[$id];
	  }
	  return $v;
	  } */
//-------------------------------------------------------------------
	/* {	get
	  @call get($vars, $id, $def)

	  Возвращает элемент(ы) массива, определяемые с помощью $id (обычно это
	  индекс(ы) выбираемых элементов массива).

	  Функция принимает 3 аргумента:
	  @arg $vars - исходный массив, из кторого выбираются элементы.
	  @arg $id - комлексный параметр определяющий выбираемые значения.
	  @arg $def - значение по умолчанию, подставляемое для не существующих в $vars элементов.


	  @eg $a = array('a'=>'A','b'=>'B','c'=>'C');
	  .	$v = vget($a, 'b');
	  .	// $v = 'B'

	  Еслим $id представлен массивом, результаттом будет ассоциативный
	  массив представляющий выборку значений из $vars с индексами
	  представлеными $id. Причем, если $def указан отсутсвующий в $vars
	  элемент будет помещён в результируюший масив с значением по умолчанию.

	  @eg $v = vget($a, array('b','d','a'));
	  .	// 	$v = array('b'=>'B','a'=>'A').

	  @eg $v = vget($a, array('b','d','a'), '*') ;
	  @.	// 	$v = array('b'=>'B','d'=>'*','a'=>'A').

	  Если $id представлен ассоциативным массивом ($alias=>$id), то ключ
	  элементов этого массива ($alias) переноситься в результирующий
	  массив вместо указанного в значении $id.

	  @eg $v = vget($a, array('c'=>'b','a'));
	  .	//  $v = array('c'=>'B','a'=>'A').

	  Если значение элемента массива $id представлено массивом, выполняется
	  выборка по vget но уже для этого элемента массива.

	  @eg $v = vget($a, array('a','vars'=>('c','b')));
	  .	//  $v = array('a'=>'A','vars'=>array('c'=>'C','b'=>'B')).

	  Для скалярного $id эта функция аналогична функции bydef().
	  } */
	public static function get($vars, $id, $def=null)
	{

		if(is_array($vars))
		{
			if(!isset($id))
				return $vars;
			if(is_scalar($id))
				return isset($vars[$id]) ? $vars[$id] : $def;

			if(is_array($id))
			{
				if(!isset($vars))
					return null;
				$res = array();
				foreach($id as $as => $i)
				{
					if(is_scalar($i))
					{
						if(isset($vars[$i]) || array_key_exists($i, $vars))
							$res[is_int($as) ? $i : $as] = $vars[$i];
						else
						if(isset($def))
							$res[is_int($as) ? $i : $as] = $def;
					} else
					if(is_array($i))
					{
						$res[$as] = v::get($vars, $i, $def);
					} else
					if(is_object($i))
					{
						// ...
					}
				}
				return $res;
			}
		} else
		if(is_object($vars))
		{
			$res = array();
			if(!isset($id))
			{
				foreach($vars as $n => $v)
					$res[$n] = $v;
				return $res;
			}
			if(is_scalar($id))
				return isset($vars->$id) ? $vars->$id : $def;
			if(is_array($id))
			{
				if(!isset($vars))
					return null;
				foreach($id as $as => $i)
				{
					if(is_scalar($i))
					{
						if(isset($vars->$i))
							$res[is_int($as) ? $i : $as] = $vars->$i;
						else
						if(isset($def))
							$res[is_int($as) ? $i : $as] = $def;
					} else
					if(is_array($i))
					{
						$res[$as] = v::get($vars, $i, $def);
					} else
					if(is_object($i))
					{
						// ...
					}
				}
				return $res;
			}
		}
	}

//-------------------------------------------------------------------
//
	/* {	sel
	  Функция выполняет выборку элементов из $vars удовлетворяющих условию в $e.

	  @call vsel($vars, $e=true)

	  Возвращает не пустые элементы массива $vars.
	  Пустыми элементами считаются: null, пустой массив и пустая строка.

	  @call vsel($vars, $e=false)

	  Возвращает пустые элементы массива $vars.

	  @call vsel($vars, $e:string)

	  Строковый аргумент $e определяет выражение для условия выборки.
	  Переменные $v и $k используемые в выражении представляют собой соответсвенно
	  значение и ключ элемента массива. Если вычечленное для элемента массива
	  выражение возвращает истину, елемент попадает в результирующий массив.

	  @eg	$a = array('a'=>12,'b'=>5,'c'=>0,'d'=>'8');
	  .	$s = vsel($a,'$v%2==0');		//	$s = array('a'=>12,'c'=>0,'d'=>'8');
	  .	$s = vsel($a,'ord($k)%2==0');	//	$s = array('b'=>5,'d'=>'8');

	  } */
	public static function sel($vars, $e=true)
	{
		$sel = array();
		if(is_bool($e))
		{
			foreach($vars as $k => $v)
				if((is_scalar($v) && strlen($v) || !empty($v)) === $e)
					$sel[$k] = $v;
			return $sel;
		}
		if(is_string($e))
		{
			static $funcs = array();
			if(!isset($funcs[$e]))
				$funcs[$e] = create_function('$v,$k', 'return ' . $e . ';');
			$e = $funcs[$e];
		}
		foreach($vars as $k => $v)
			if(call_user_func($e, $v, $k))
				$sel[$k] = $v;
		return $sel;
	}

//-------------------------------------------------------------------
//
	/* { map
	  Возвращает массив с модифицированными выражением $e элементами исходного
	  $vars массива. $e представляет собой тело функции с параметрами $v и $k,
	  представляющие собой значение и ключ элемента исходного массива. Изменяя
	  значение параметров мы получаем элемент результирующего массива. Если $e
	  возвращает false, то обрабатываемый элемент массива не попадпет в
	  результирующий массив.

	  Если строка выражение начинается со знака '=', $e заменяется
	  выражением '$v="'.substr($e,1).'"'.

	  @eg	$a = array('a'=>2,'b'=>5);
	  .	$m = vmap($a,'$k.=$k; $v+=$v;');	// $m = array('aa'=>4,'bb'=>10);
	  .	$m = vmap($a,'return $v%2==1');		// $m = array('b'=>5);
	  .	$m = vmap($a,'=($k=$v)');			// $m = array('a'=>'(a=2)','b'=>'(b=5)');

	  @eg	$a = array('a'=>array('f1'=>'A','f2'=>'B'),'b'=>array('f1'=>'a','f2'=>'b'));
	  .	$m = vmap($a,'$v=$v["f1"];');		// $m = array('a'=>'A','b'=>'a');
	  .	$m = vmap($a,'={$v[\'f1\']}');		// $m = array('a'=>'A','b'=>'a');
	  .	$m = vmap($a,'[f1]');				// $m = array('a'=>'A','b'=>'a');
	  .	$m = vmap($a,'[f1=>f2]');			// $m = array('A'=>'B','a'=>'b');

	  } */
	public static function map($vars, $e)
	{
		static $funcs = array();
		if($e[0] == '[')
		{
			if(sizeof($e = explode('=>', substr($e, 1, -1))) == 1)
			{
				$e = '$v=$v[\'' . $e[0] . "']";
			} else
			{
				$e = '$k=$v[\'' . $e[0] . '\']; $v=$v[\'' . $e[1] . "']";
			}
		}

		if($e[0] == '=')
			$e = '$v="' . addcslashes(substr($e, 1), '"') . '"';
		if(!isset($funcs[$e]))
			$funcs[$e] = create_function('&$v,&$k', $e . ';');
		$e = $funcs[$e];

		reset($vars);
		$map = array();
//	why foreach instead of whule(each)	?
//	foreach ($vars as $k=>$v) if(call_user_func_array($e, array(&$v, &$k))!==false) $map[$k]=$v;
		while(list($k, $v) = each($vars))
			if(call_user_func_array($e, array(&$v, &$k)) !== false)
				$map[$k] = $v;
		return $map;
	}

	/*
	  public static function vmap($vars, $e)
	  {
	  static $funcs=array();
	  if (!isset($funcs[$e])) $funcs[$e]=create_public static function('&$v,&$k',$e.';');
	  $e = $funcs[$e];

	  $map = array();
	  foreach ($vars as $k=>$v) if(call_user_func_array($e, array(&$v, &$k))!==false) $map[$k]=$v;
	  return $map;
	  }
	 */

	/*
	  public static function vmap($vars, $e)
	  {
	  static $funcs=array();
	  if (!isset($funcs[$e])) $funcs[$e]=create_public static function('&$v,&$k',$e.';');
	  $e = $funcs[$e];

	  $map = array();
	  foreach ($vars as $k=>$v) if(call_user_func_array($e, array(&$v, &$k))!==false) $map[$k]=$v;
	  return $map;
	  }
	 */

//-------------------------------------------------------------------
//
	/* { vpref
	  Возвращает элементы массива ключ которых начинается с префикса $getPref.

	  @eg $a = array('_a'=>'A','b'=>'B','_c'=>'C');
	  .	$v = vpref($a, '_');		// $v = array('_a'=>'A','_c'=>'C');

	  Если указан 3ий аргумент, тогда исходный префикс найденных элементов
	  заменяется на префикс $setPref.

	  @eg	$v = vpref($a, '_','-');	// $v = array('-a'=>'A','-c'=>'C');
	  .	$v = vpref($a, '_','');		// $v = array('a'=>'A','c'=>'C');

	  } */
	public static function pref($vars, $getPref, $setPref=null)
	{
		$sel = array();
		$pref = strlen($getPref);
		foreach($vars as $i => $v)
		{
			if(!$pref || substr($i, 0, $pref) == $getPref)
			{
				if(isset($setPref))
				{
					$sel[$setPref . ($pref ? substr($i, $pref) : $i)] = $v;
				} else
				{
					$sel[$i] = $v;
				}
			}
		}
		return $sel;
	}

//------ vjoin ----------------------------------------------------
//
	/* { vjoin
	  Склеивает элементы массива $vars в одну строчку.
	  Если аргумент $f представлен строкой, то он является склейкой.

	  Если $f представлен массивом то выполняются следующие этапы обработки:
	 *  	при наличии $f['itm'] форматируются элементы масива с помощью vmap;
	 * 	элементы склеиваются с помощью $f['sep'] склейки;
	 * 	если полученая строка НЕ ПУСТАЯ она обрамляется $f['beg'] и $f['end'].
	 * 	полученая строка обрамляется $f['fst'] и $f['lst'].

	  @eg	$a = array('_a'=>'A','b'=>'B','_c'=>'C');
	  .	$v = vjoin($a, 'my array |[|=$k:$v|,|]|!','|');
	  .	$v = vjoin($a, array('fst'=>'my array ','beg'=>'[','itm'=>'=$k:$v','sep'=>',','end'=>']','lst'=>'!'));
	  .	// $v = 'my array [_a:A,b:B,_c:C]!';

	  } */
	public static function join($vars, $f, $sep=null)
	{
		if(!is_array($vars))
			return $vars;
		if(is_string($f))
		{
			if(!$sep)
				return implode($f, $vars);
			$f = explode($sep, $f);
			$f = vget($f, array('fst' => 0, 'beg' => 1, 'itm' => 2, 'sep' => 3, 'end' => 4, 'lst' => 5));
		}

		if(isset($f['itm']))
			$vars = self::map($vars, $f['itm']);
		if(strlen($out = implode(v::get($f, 'sep', ''), $vars)))
		{
			if(isset($f['beg']))
				$out = $f['beg'] . $out;
			if(isset($f['end']))
				$out = $out . $f['end'];
		}
		if(isset($f['fst']))
			$out = $f['fst'] . $out;
		if(isset($f['lst']))
			$out = $out . $f['lst'];

		return $out;
	}

//-------------------------------------------------------------------
	/* {	vset
	  Функция копирует элементы массива из $src в $dst массив. Если пераметр
	  $reset установлен в false, выполняется слияние массивов посредством
	  функции array_merge(). Если $reset установлен в true, $dst очищается.
	  }
	  public static function vset(&$dst, $src, $reset=false)
	  {
	  $dst = $reset ? $src : array_merge($dst, $src);
	  }
	 */
//-------------------------------------------------------------------
	/* {	vupdate
	  Функция копирует элементы массива из $src в $dst массив. При этом, любой
	  элемент из $src перетирает элемент в $dst с одним и тем же индексом.
	  Если значение элемента в $src установлено в null и $pack=true, то
	  соответствующий элемент в $dst удаляется.
	  }
	  public static function vupdate(&$dst, $src, $pack=true)
	  {
	  foreach($src as $n=>$v) if (isset($v) || !$pack) $dst[$n] = $v; else unset($dst[$n]);
	  }
	 */

//-------------------------------------------------------------------
	/* {
	  Функция рекурсивного копирования элементов массива $src в $dst.
	  Рекурсивное копирование применяется только если соответствующие
	  элементы из $src и $dst являются массивами. В противном случае,
	  значение элемента из $src перетирает элемент из $dst.
	  } */
	public static function apply(&$dst, $src)
	{
		foreach($src as $n => $v)
		{
			if(isset($dst[$n]) && is_array($dst[$n]) && is_array($v))
			{
				vapply($dst[$n], $v);
			} else
			{
				$dst[$n] = $v;
			}
		}
	}

//-------------------------------------------------------------------
	/* {
	  Возвращает значение первого элемента, удаляя этот элемент из массива.
	  При удалении сохраняются индексы оставшихся элементов.
	  Рекомендуется использывать эту функцию для больших массивов вместо
	  стандартной array_shift.
	  } */
	public static function shift(&$vars)
	{
		$r = reset($vars);
		unset($vars[key($vars)]);
		return $r;
	}

//===================================================================
	/* {	list

	  @call vlist($lst:string, $val)
	  Возвращает упаковынный в строке $lst массив. Каждый элемент массива
	  в строке представляется парой 'name=value', где `name` ключ элемента
	  массива, а `value` - значение. 'value' может быть опущен, тогда
	  значение элемента будет установлено в $val.
	  Первый символ строки определяет разделитель, которым объеденены между
	  собой элементы массива. Если первый символ буква, цифра или символ
	  '_' подчёркивание разделителем считается символ ';' точка с запятой.

	  @call vlist($lst:array, $val)
	  Данный вариант функции позволяет построить ассоциативный массив
	  из исходного массива. Если ключ элемента исходного массива представлен
	  строкой, то этот элемент попадает в результирующий массив без изменений.
	  Если ключ элемента исходного массива является индексом (числовое значение),
	  то значение исходного элемента становится ключом результирующего элемента,
	  а значение устанавливается в $val. Если $val пустой ($val==null), то
	  значение исходного элемента копируется в значение результирующего.

	  } */

	/**
	 * Enter description here...
	 *
	 * @param string $lst
	 * @param mixed $val
	 * @return array
	 *
	 * vlist($lst:string, $val)
	 * Возвращает упаковынный в строке $lst массив. Каждый элемент массива
	 * в строке представляется парой 'name=value', где `name` ключ элемента
	 * массива, а `value` - значение. 'value' может быть опущен, тогда
	 * значение элемента будет установлено в $val.
	 * Первый символ строки определяет разделитель, которым объеденены между
	 * собой элементы массива. Если первый символ буква, цифра или символ
	 * '_' подчёркивание разделителем считается символ ';' точка с запятой.
	 *
	 * @param array $lst
	 * @param mixed $val
	 * @return array
	 *
	 * vlist($lst:array, $val)
	 * Данный вариант функции позволяет построить ассоциативный массив
	 * из исходного массива. Если ключ элемента исходного массива представлен
	 * строкой, то этот элемент попадает в результирующий массив без изменений.
	 * Если ключ элемента исходного массива является индексом (числовое значение),
	 * то значение исходного элемента становится ключом результирующего элемента,
	 * а значение устанавливается в $val. Если $val пустой ($val==null), то
	 * значение исходного элемента копируется в значение результирующего.
	 *
	  public static function vlist($lst, $val=null)
	  {
	  $vlst = array();
	  if (is_string($lst)) {
	  if ($lst) {
	  $sep = ';';
	  if (!preg_match('/^[\w-]/',$lst)) {
	  $sep = $lst{0};
	  $lst = substr($lst,1);
	  }
	  foreach(explode($sep, $lst) as $l) {
	  $p = explode('=', $l, 2);
	  if (strpos($p[0], '/')!==false) {
	  eval("\$vlst['".str_replace('/',"']['",$p[0])."'] = \$p[1];");
	  } else {
	  $vlst[$p[0]] = isset($p[1]) ? $p[1] : (isset($val) ? $val : $p[0]);
	  }
	  }
	  }
	  } else {
	  foreach($lst as $n=>$v) {
	  if(is_string($n)) 	$vlst[$n] = $v;
	  else				$vlst[$v] = isset($val) ? $val : $v;
	  }
	  }
	  return $vlst;
	  }
	 */
//------- trim -----------------------------------------------------
//
	public static function trim($var)
	{
		if(is_array($var))
		{
			foreach($var as $i => $v)
				$var[$i] = self::trim($v);
		} elseif(is_string($var))
		{
			$var = trim($var);
		}
		return $var;
	}

//------- unslash ---------------------------------------------------
//
	public static function unslash($var)
	{
		if(is_array($var))
		{
			foreach($var as $i => $v)
				$var[$i] = self::unslash($v);
		} elseif(is_string($var))
		{
			$var = stripslashes($var);
		}
		return $var;
	}

//------------------------------------------------------------------------------
//
	public static function iname($name, $defchar='_', $len=0)
	{
		$mb = array(
			'Ж' => 'zh', 'ж' => 'zh', 'Ч' => 'ch', 'ч' => 'ch', 'Ш' => 'sh', 'ш' => 'sh', 'Щ' => 'sch', 'щ' => 'sch',
			'Ю' => 'yu', 'ю' => 'yu', 'Я' => 'ya', 'я' => 'ya', 'ї' => 'ji', 'Ї' => 'ji'
		);
		$from = 'АБВГДЕЁЗИЙКЛМНОПРСТУФХЦЪЫЬЭабвгдеёзийклмнопрстуфхцъыьэєЄіІ';
		$into = "abvgdeezijklmnoprstufhc y eabvgdeezijklmnoprstufhc y eeeii";
		$name = strtr($name, $mb);
		$name = strtr($name, $from, $into);
		$name = preg_replace('/[\x00-\x1F]/', '', $name);
		$name = preg_replace('/[^.\w]/', $defchar, $name);
		$name = preg_replace('/' . $defchar . '+/', $defchar, $name);
		$name = strtolower(trim($name, $defchar));
		if($len)
		{
			while(strlen($name) > $len && false !== ($sfx = strrchr($name, $defchar)))
			{
				$name = substr($name, 0, -$len);
			}
			if(strlen($name) > $len)
				$name = substr($name, 0, $len);
		}
		return $name;
	}

	public static function iid($name, $defchar='_', $len=0)
	{
		return SystemName(str_replace('.', '_', $name), $defchar, $len);
	}

}