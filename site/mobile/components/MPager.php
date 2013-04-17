<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 2/11/13
 * Time: 4:35 PM
 * To change this template use File | Settings | File Templates.
 */
class MPager extends CBasePager
{
    public function run()
    {
        if ($this->getPageCount() > 0)
            $this->render('MPager');
    }
}
