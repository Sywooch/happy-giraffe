<?php

class TasksController extends ELController
{
	public function actionIndex()
	{
        $task = ELTask::getNextTask();
        if ($task === null)
		    $this->render('empty');
        else
            $this->render('index');
	}
}