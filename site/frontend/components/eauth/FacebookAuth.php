<?php
/**
 * @author Никита
 * @date 16/02/16
 */

class FacebookAuth extends FacebookOAuthService
{
    protected $scope = 'public_profile, email';

    protected function fetchAttributes()
    {
        $info = (object)$this->makeSignedRequest('https://graph.facebook.com/me', array(
            'query' => array(
                'fields' => 'first_name, last_name, email, gender, picture.height(200).width(200)',
            ),
        ));

        $this->attributes['uid'] = $info->id;
        $this->attributes['firstName'] = $info->first_name;
        $this->attributes['lastName'] = $info->last_name;
        if (isset($info->email)) {
            $this->attributes['email'] = $info->email;
        }
        $this->attributes['gender'] = $this->processGender($info->gender);
        $this->attributes['avatarSrc'] = $info->picture->data->url;
    }

    protected function processGender($fbGender)
    {
        switch ($fbGender) {
            case 'male':
                return 1;
                break;
            case 'female':
                return 0;
                break;
            default:
                return null;
        }
    }

}