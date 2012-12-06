<?php
/**
 * User: alexk984
 * Date: 6/12/12
 */
class serviceSocialWidget extends CWidget
{
    public $service;
    public $image;
    public $description;
    public $counter_title = array('Сервис помог определить пол уже', array('будущиму родителю','будущим родителям','будущим родителям'));

    public function run()
    {
        $this->render('index', array(
            'service' => $this->service,
            'image' => $this->image,
            'description' => $this->description,
        ));
    }
}
