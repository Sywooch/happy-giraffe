<?php
/**
 * User: Eugene Podosenov
 * Date: 15.06.12
 */
class MailModule extends CWebModule
{
    public $groupId;
    public function init()
    {
        $this->setImport(array(
            'mail.models.*',
        ));
    }
}
