<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 31/07/14
 * Time: 12:10
 */

Yii::import('zii.widgets.CListView');

class LiteListView extends CListView
{
    public $ajaxUpdate = false;
    public $cssFile = false;
    public $template = '{items}<div class="yiipagination">{pager}</div>';
    public $itemsTagName = 'ul';
    public $itemsCssClass = 'traditional-recipes_ul';
    public $pager = array(
        'class' => 'LitePager',
    );
    public $htmlOptions = array(
        'class' => 'traditional-recipes',
    );
} 