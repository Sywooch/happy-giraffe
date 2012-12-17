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
        return new CActiveDataProvider('User', array(
            'criteria' => array(
                'condition' => 't.id != :hg',
                'params' => array(':hg' => User::HAPPY_GIRAFFE),
                'with' => array(
                    'avatar',
                    'partner' => array(
                        'with' => array(
                            'photo' => array(
                                'alias' => 'partnerAttach',
                                'with' => array(
                                    'photo' => array(
                                        'alias' => 'partnerPhoto',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'babies' => array(
                        'with' => array(
                            'photo' => array(
                                'alias' => 'babyAttach',
                                'with' => array(
                                    'photo' => array(
                                        'alias' => 'babyPhoto',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ));
    }
}
