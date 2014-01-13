<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 13/01/14
 * Time: 12:06
 * To change this template use File | Settings | File Templates.
 */

class AntispamController extends HController
{
    const TYPE_LIVE = 1;
    const TYPE_TOP50 = 2;
    const TYPE_OLDUSERS = 3;

    public function actionIndex($type = self::TYPE_LIVE)
    {
        $criteria = new CDbCriteria(array(
            'order' => 'id DESC',
        ));

        switch ($type) {
            case self::TYPE_TOP50:
                $ids = array(135309, 128489, 134087, 134294, 130651, 134492, 130380, 135526, 135471, 134370, 133406, 128595, 133838, 146583, 134027, 135313, 132109, 134383, 134090, 146930, 146615, 145537, 146914, 134317, 135721, 128447, 134467, 128519, 147678, 132256, 146657, 132925, 134501, 134362, 129297, 146924, 128596, 128469, 133630, 134304, 146662, 124716, 145287, 146634, 146610, 146904, 146625, 136440, 130063, 132940);
                $criteria->addInCondition('t.id', $ids);
                break;
            case self::TYPE_OLDUSERS:
                $criteria->with = array('author');
                $criteria->condition = 'author.register_date < :register_date AND t.created > :created';
                $criteria->params = array(
                    ':register_date' => '2014-01-01 00:00:00',
                    ':created' => '2014-01-07 00:00:00',
                );
                break;
        }

        $dp = new CActiveDataProvider('BlogContent', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));

        Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
        $this->render('live', compact('dp'));
    }
}