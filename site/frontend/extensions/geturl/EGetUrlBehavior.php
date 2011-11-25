<?php
/**
 * Status behavior for models.
 *
 * @author Veaceslav Rudnev <slava.rudnev@gmail.com>
 *
 * @version 0.1
 */
class EGetUrlBehavior extends CActiveRecordBehavior
{
	/**
	 * @var string the name of the table field where pk is stored.
	 * Required to set on init behavior. No default.
	 */
//	public $idField = NULL;
	/**
	 * @var string the name of the table field where data is stored.
	 * Required to set on init behavior. No default.
	 * array('title'=>'model_tittle',...)
	 */
	public $dataField = array();

	public $route = 'view';

	private $_urlParams = array();
	
	/**
	 * Check required properties and attaches the behavior object to the component.
	 * @param CComponent owner component.
	 * @throws CException if required properties not set.
	 */
	public function attach($owner)
	{
		// Check required var route.
		if (!is_string($this->route) || empty($this->route))
			throw new CException(Yii::t('yii', 'Property "{class}.{property}" is not defined.',
				array('{class}' => get_class($this), '{property}' => 'route')));

		// Check required var dataField.
		if (!is_array($this->dataField) || empty($this->dataField))
			throw new CException(Yii::t('yii', 'Property "{class}.{property}" is not defined.',
				array('{class}' => get_class($this), '{property}' => 'dataField')));

		parent::attach($owner);
	}

	public function __toString()
	{
		return $this->getUrl(true);
	}

	public function getUrl($abs = false)
	{
		$owner = $this->getOwner();

		foreach ($this->dataField as $field) {
			if(!is_string($field) || empty($field) || !$owner->hasAttribute($field))
				throw new CException(Yii::t('yii', 'Property "{class}.{property}" is not defined.',
					array('{class}' => get_class($owner), '{property}' => $field)));
		}

		foreach ($this->dataField as $key=>$field) {
			$this->_urlParams[$key] = $owner->getAttribute($field);
		}

		if($abs)
			return Yii::app()->createAbsoluteUrl($this->route, $this->_urlParams);

		$url = $this->_urlParams;
		array_unshift($url, $this->route);
		
		return $url;
	}
}
