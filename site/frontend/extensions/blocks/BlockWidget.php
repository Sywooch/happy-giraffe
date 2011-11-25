<?php

class BlockWidget extends CWidget
{

	public $block_name;
	public $params = array();
	
	public function run()
	{
		
		$block = new Block($this->params);
		$this->render('layout', array(
			'block_name' => $this->block_name,
			'content' => $block->generate(),
		));
	}	
	
}