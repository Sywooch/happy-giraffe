<?php
class CustomFacebookService extends FacebookOAuthService
{
	/**
	 * https://developers.facebook.com/docs/authentication/permissions/
	 */
	protected $scope = 'user_birthday';

	/**
	 * http://developers.facebook.com/docs/reference/api/user/
	 * @see FacebookOAuthService::fetchAttributes()
	 */
	protected function fetchAttributes() {
		$this->attributes = (array) $this->makeSignedRequest('https://graph.facebook.com/me');
        if(!isset($this->attributes['first_name']))
            $this->attributes['first_name'] = $this->attributes['name'];
	}
}
