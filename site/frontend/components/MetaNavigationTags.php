<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MetaNavigationTags
 *
 * @author Кирилл
 */
class MetaNavigationTags extends CComponent
{

    public $prev = null;
    public $next = null;
    public $last = null;
    public $first = null;

    public function render()
    {
        $cs = Yii::app()->clientScript;
        if ($this->prev)
            $cs->registerLinkTag('prev', null, $this->prev);
        if ($this->next)
            $cs->registerLinkTag('next', null, $this->next);
        if ($this->first)
            $cs->registerLinkTag('first', null, $this->first);
        if ($this->last)
            $cs->registerLinkTag('last', null, $this->last);
    }

}

?>
