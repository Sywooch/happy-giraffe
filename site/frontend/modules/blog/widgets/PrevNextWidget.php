<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 29/10/13
 * Time: 14:03
 * To change this template use File | Settings | File Templates.
 */

class PrevNextWidget extends CWidget
{
    public $post;

    public function run()
    {
        $prev = $this->post->getPrevPost();
        $next = $this->post->getNextPost();

        if ($prev !== null || $next !== null)
            $this->render('PrevNextWidget', compact('prev', 'next'));
    }
}