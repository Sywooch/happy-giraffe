<?php

/**
 * Description of AttributeSetBehavior
 *
 * @author Slava Rudnev <slava.rudnev@gmail.com>
 */
class AttributeSetBehavior extends CActiveRecordBehavior
{
	public $table = 'attribute_set';

	public $attribute = '';

	/**
	 *
	 * @param CActiveRecord $owner
	 */
	public function attach($owner)
	{
		if(!$owner->hasAttribute($this->attribute))
			throw new Exception("AttributeSetBehavior - unknown attribute '{$this->attribute}'");

		parent::attach($owner);
	}

	/**
	 * Return array of sets
	 * @return array
	 */
	public function getAllSets()
	{
		$sets = Y::command()
			->select('set_id, set_title')
			->from($this->table)
			->queryAll();

		return CHtml::listData($sets, 'set_id', 'set_title');
	}

	public function getSetTitle()
	{
		$owner = $this->getOwner();

		return Y::command()
			->select('set_title')
			->from($this->table)
			->where('set_id=:set_id', array(
				':set_id'=>$owner->getAttribute($this->attribute),
			))
			->queryScalar();
	}
}