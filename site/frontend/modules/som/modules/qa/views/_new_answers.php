<?php

/**
 * @var site\frontend\modules\som\modules\qa\controllers\DefaultController $this
 * @var \site\frontend\modules\som\modules\qa\models\QaCTAnswer $data
 */

if ($data->authorIsSpecialist())
{
    $this->renderPartial('/_new_answer_pediator', ['data' => $data]);
} else {
    $this->renderPartial('/_new_answer_user', ['data' => $data]);
}