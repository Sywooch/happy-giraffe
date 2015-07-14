<?php
/**
 * @author Никита
 * @date 13/07/15
 */

class HeaderGuestSectionsWidget extends CWidget
{
    public function run()
    {
        $sections = CommunitySection::model()->with('clubs')->findAll();
        $sequence = array(4, 1, 2, 3, 5, 6);

        usort($sections, function($a, $b) use ($sequence) {
           return array_search($a->id, $sequence) > array_search($b->id, $sequence);
        });

        $this->render('HeaderGuestSectionsWidget', compact('sections'));
    }
}