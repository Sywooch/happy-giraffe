<?php

/*
 * DateTimeI18NBehavior
 * Automatically converts date and datetime fields to I18N format
 *
 * Author: Ricardo Grana <rickgrana@yahoo.com.br>, <ricardo.grana@pmm.am.gov.br>
 * Version: 1.1
 * Requires: Yii 1.0.9 version
 */

class I18nDateTimeBehavior  extends CActiveRecordBehavior
{
	public $dateOutcomeFormat = 'Y-m-d';
	public $dateTimeOutcomeFormat = 'Y-m-d H:i:s';

	public $dateIncomeFormat = 'yyyy-MM-dd';
	public $dateTimeIncomeFormat = 'yyyy-MM-dd hh:mm:ss';
	public $fields; // array of ('field_name'=>'type')

	public $intvals = array();

	public function beforeSave($event)
	{
		$model = &$event->sender;
		foreach($this->fields as $name => $type)
		{
			if (!strlen($model->$name)) continue;
			$in = $model->$name;
			switch($type) {
			case 'i-date':
			case 'i-date-floor':	$out = self::parse2int($in, $this->dateIncomeFormat /*Yii::app()->locale->getDateFormat('short')*/); break;
			case 'i-date-ceil':		if ($out = self::parse2int($in, $this->dateIncomeFormat /*Yii::app()->locale->getDateFormat('short')*/)) $out+=24*60*60-1; break;
			default: 				throw new Exception("I18nDateTimeBehavior - unknown field type '$type'");
			}
			$model->$name = $this->intvals[$name] = $out;

		/*
			if (($column->dbType == 'date')) {
				$event->sender->$columnName = date($this->dateOutcomeFormat, CDateTimeParser::parse($event->sender->$columnName, Yii::app()->locale->dateFormat));
			}else{

				$event->sender->$columnName = date($this->dateTimeOutcomeFormat,
					CDateTimeParser::parse($event->sender->$columnName,
						strtr(Yii::app()->locale->dateTimeFormat,
							array("{0}" => Yii::app()->locale->timeFormat,
								  "{1}" => Yii::app()->locale->dateFormat))));
			}
		*/
		}
		return true;
	}
	public function afterSave($event)
	{
		$model = &$event->sender;
		foreach($this->fields as $name => $type)
		{
			$in = $this->intvals[$name] = $model->$name;
			if ($in) {
				switch($type) {
				case 'i-date':
				case 'i-date-floor':	$out = Yii::app()->dateFormatter->format($this->dateOutcomeFormat, $in); break;
				case 'i-date-ceil':		$out = Yii::app()->dateFormatter->format($this->dateOutcomeFormat, $in); break;
				default: 				throw new Exception("I18nDateTimeBehavior - unknown field type '$type'");
				}
			} else {
				$out = '';
			}
			$model->$name = $out;
		}
		return true;
	}


	public function afterFind($event)
	{
		$this->afterSave($event);
		return true;
	}

	/**
	 *
	 */
	static function parse2int($value, $format)
	{
		$format = preg_split('#\W+#',$format);
		$value  = preg_split('#\D+#',$value);

		$dt = array();
		foreach($format as $f) {
			$dt[$f[0]] = array_shift($value);
		}
		return mktime(
			0+isset($dt['h'])?$dt['h']:0,
			0+isset($dt['m'])?$dt['m']:0,
			0+isset($dt['s'])?$dt['s']:0,
			0+isset($dt['M'])?$dt['M']:0,
			0+isset($dt['d'])?$dt['d']:0,
			0+isset($dt['y'])?$dt['y']:0
		);
	}
}