<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 02/06/14
 * Time: 15:48
 */

class CommentatorController extends HController
{
    public $list = array(
        15426,
        15814,
        15994,
        159841,
        167771,
        175718,
        189230,
    );

    public function actionComments($userId = null)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('removed', 0);
        $criteria->addCondition('t.created > DATE_SUB(NOW(), INTERVAL 1 MONTH)');
        if ($userId === null) {
            $criteria->addInCondition('author_id', $this->list);
        } else {
            $criteria->compare('author_id', $userId);
        }

        $dp = new CActiveDataProvider('Comment', array(
            'criteria' => $criteria,
        ));

        $usersCriteria = new CDbCriteria();
        $usersCriteria->addInCondition('t.id', $this->list);
        $commentators = User::model()->findAll($usersCriteria);

        $menuItems = array_map(function(User $user) {
            return array(
                'label' => $user->getFullName(),
                'url' => array('/antispam/commentator/comments', 'userId' => $user->id),
            );
        }, $commentators);

        $this->render('index', compact('dp', 'menuItems'));
    }
} 