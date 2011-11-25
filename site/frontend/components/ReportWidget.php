<?php

class ReportWidget extends CWidget
{

	public $source_data;
	
	public function run()
	{
		$report = new Report;
		$this->render('form', array(
			'report' => $report,
			'source_data' => $this->source_data,
		));
	}	
	
}