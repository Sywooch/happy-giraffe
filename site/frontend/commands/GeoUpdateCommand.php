<?php

class GeoUpdateCommand extends CConsoleCommand {

	public function run()
	{
		$rp = new RussianPost();
		$rp->update();	
	}
}