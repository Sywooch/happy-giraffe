<?php
/**
 * EAuthRedirectWidget class file.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

/**
 * The EAuthRedirectWidget widget displays the redirect page after returning from provider.
 * @package application.extensions.eauth
 */
class EAuthRedirectWidget extends CWidget {

	/**
	 * @var mixed the widget mode. Default to "login".
	 */
	public $url = null;

	/**
	 * @var boolean whether to use redirect inside the popup window.
	 */
	public $redirect = true;

	public $view = 'redirect';

    public $inc;

    public $service;

    public $in_popup = false;

	/**
	 * Executes the widget.
	 */
    public function run() {
		$assets_path = dirname(__FILE__).DIRECTORY_SEPARATOR.'assets';
		$this->render($this->view, array(
			'id' => $this->getId(),
			'url' => $this->url,
			'redirect' => $this->redirect,
			'assets_path' => $assets_path,
            'in_popup' => $this->in_popup,
            'inc' => $this->inc,
            'service' => $this->service,
		));
		Yii::app()->end();
    }
}
