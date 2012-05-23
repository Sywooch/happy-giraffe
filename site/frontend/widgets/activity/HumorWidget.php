<?php
/**
 * Author: choo
 * Date: 18.05.2012
 */
class HumorWidget extends CWidget
{
    public function run()
    {
        $humor = Humor::model()->with('photo')->find(array(
            'order' => 't.id DESC',
        ));
        $this->render('HumorWidget', compact('humor'));
    }
}
