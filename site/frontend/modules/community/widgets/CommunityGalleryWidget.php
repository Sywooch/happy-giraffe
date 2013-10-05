<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 10/4/13
 * Time: 8:17 PM
 * To change this template use File | Settings | File Templates.
 */

class CommunityGalleryWidget extends CWidget
{
    public $content;

    public function run()
    {
        $widgets = CommunityContentGalleryWidget::model()->findAll(array(
            'with' => array(
                'gallery' => array(
                    'with' => array(
                        'content' => array(
                            'with' => array(
                                'rubric' => array(
                                    'with' => 'community',
                                ),
                            ),
                        ),
                    ),
                ),
                'item',
            ),
            'condition' => 't.club_id = :clubId AND content.id != :contentId AND t.hidden = 0',
            'params' => array(':clubId' => $this->content->rubric->community->club_id, ':contentId' => $this->content->id),
        ));
        if ($widgets) {
            $shownWidgets = Yii::app()->user->getState('shownWidgets', array());
            $widgetToShow = null;
            foreach ($widgets as $w) {
                if (! isset($shownWidgets[$w->id])) {
                    $widgetToShow = $w;
                    break;
                } elseif ($widgetToShow === null || $shownWidgets[$w->id] < $shownWidgets[$widgetToShow])
                    $widgetToShow = $w;
            }

            if (array_search($widgetToShow->id, $shownWidgets) === false)
                $shownWidgets[$widgetToShow->id] = 1;
            else
                $shownWidgets[$widgetToShow->id] += 1;
            Yii::app()->user->setState('shownWidgets', array());

            $this->render('CommunityGalleryWidget', compact('widgetToShow'));
        }
    }
}