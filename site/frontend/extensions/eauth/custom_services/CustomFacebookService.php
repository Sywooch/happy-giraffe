<?php
/**
 * An example of extending the provider class.
 *
 * @author ChooJoy <choojoy.work@gmail.com>
 * @link http://code.google.com/p/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
 
require_once dirname(dirname(__FILE__)).'/services/FacebookOAuthService.php';

class CustomFacebookService extends FacebookOAuthService
{
    protected function fetchAttributes() {
        $info = (object) $this->makeSignedRequest('https://graph.facebook.com/me');
        $this->attributes['id'] = $info->id;
        $this->attributes['name'] = $info->name;
        $this->attributes['url'] = $info->link;
        if(isset($info->email))
            $this->attributes['email'] = $info->email;

        if(isset($info->first_name))
            $this->attributes['first_name'] = $info->first_name;
        else
            $this->attributes['first_name'] = $info->name;

        if(isset($info->last_name))
            $this->attributes['last_name'] = $info->last_name;
    }
}
