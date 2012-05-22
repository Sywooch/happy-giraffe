<?php
/**
 * Author: choo
 * Date: 18.05.2012
 */
class HumorWidget extends CWidget
{
    public function run()
    {
        $humor = Humor::model()->with('photo')->findByPk(1);
        $this->render('HumorWidget', compact('humor'));
    }
}
