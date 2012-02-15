<?php
class AlbumsModule extends CWebModule
{
    public $defaultController = 'album';

    public function init()
    {
        $this->setImport(array(
            'albums.components.*',
        ));
    }
}
