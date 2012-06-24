<?php
/**
 * @property MCAPI $api
 *
 */
class MailChimp extends CApplicationComponent {

  public $apiKey;

  public $list;

  protected $_api;

  /**
   * @return MCAPI
   */
    public function getApi()
    {
        if (!$this->_api) {
            Yii::import('site.common.extensions.mailchimp.vendors.MCAPI', true);
            if (isset($_ENV['COMPANY'])) {
                $this->apiKey = $this->list[$_ENV['COMPANY']];
            }
            $this->_api = new MCAPI($this->apiKey);
        }
        return $this->_api;
    }

    /**
     * @param User $user
     */
    public function saveUser($user)
    {
        $options = array($this->getUserOptions($user));
        $this->api->listBatchSubscribe($this->list, $options, false, true, false);
    }

    public function updateUsers()
    {
        $users = User::model()->active()->findAll();
        $options = array();
        foreach($users as $user)
            $options[] = $this->getUserOptions($user);

        $this->api->listBatchSubscribe($this->list, $options, false, true, false);
    }

    /**
     * @param User $user
     * @return array
     */
    private function getUserOptions($user)
    {
        $options = array(
            'EMAIL' => $user->email,
            'FNAME' => $user->first_name,
            'LNAME' => $user->last_name,
            'GENDER' => $user->gender,
        );
        if($user->age !== null)
            $options['AGE'] = $user->age;
        return $options;
    }
}
