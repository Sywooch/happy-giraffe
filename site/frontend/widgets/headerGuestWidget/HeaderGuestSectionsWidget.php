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
        $this->render('HeaderGuestSectionsWidget', compact('sections'));
    }
}