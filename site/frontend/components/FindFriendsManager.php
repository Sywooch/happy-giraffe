<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/14/12
 * Time: 2:48 PM
 * To change this template use File | Settings | File Templates.
 */
class FindFriendsManager
{
    const BY_ONLINE = 0;
    const BY_REGION = 1;
    const BY_INTERESTS = 2;
    const BY_STATUS = 3;

    public static function getDataProvider($type)
    {
        $criteria = self::getDefaultCriteria();
        $criteria->mergeWith(self::getCriteriaByType($type));

        return new CActiveDataProvider('User', array(
            'criteria' => $criteria,
        ));
    }

    public static function getCriteriaByType($type)
    {
        switch ($type) {
            case self::BY_ONLINE:
                $data = array(
                    'condition' => 'online = 1',
                );
                break;
            default:
                $data = array();
        }

        return new CDbCriteria($data);
    }

    public static function getDefaultCriteria()
    {
        return new CDbCriteria(array(
            'condition' => 't.id != :hg',
            'params' => array(':hg' => User::HAPPY_GIRAFFE),
            'with' => array(
                'avatar',
//                'partner' => array(
//                    'with' => array(
//                        'photo' => array(
//                            'alias' => 'partnerAttach',
//                            'with' => array(
//                                'photo' => array(
//                                    'alias' => 'partnerPhoto',
//                                ),
//                            ),
//                        ),
//                    ),
//                ),
//                'babies' => array(
//                    'with' => array(
//                        'randomPhoto' => array(
//                            'with' => array(
//                                'photo',
//                            ),
//                        ),
//                    ),
//                ),
            ),
        ));
    }
}
