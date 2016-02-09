<?php

namespace site\frontend\modules\v1\actions;

use site\frontend\modules\som\modules\qa\models\QaCategory;

class QaCategoriesAction extends RoutedAction
{
    public function run()
    {
        $this->route('getCategories', null, null, null);
    }

    public function getCategories()
    {
        $this->controller->get(QaCategory::model(), $this);
    }
}