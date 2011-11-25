<?php

/**
 * Description of fbLikeWidget
 *
 * @author Slava Rudnev <slava.rudnev@gmail.com>
 *
 *
 *     href - the URL to like. The XFBML version defaults to the current page.
    send - specifies whether to include a Send button with the Like button. This only works with the XFBML version.
    layout - there are three options.
        standard - displays social text to the right of the button and friends' profile photos below. Minimum width: 225 pixels. Default width: 450 pixels. Height: 35 pixels (without photos) or 80 pixels (with photos).
        button_count - displays the total number of likes to the right of the button. Minimum width: 90 pixels. Default width: 90 pixels. Height: 20 pixels.
        box_count - displays the total number of likes above the button. Minimum width: 55 pixels. Default width: 55 pixels. Height: 65 pixels.
    show_faces - specifies whether to display profile photos below the button (standard layout only)
    width - the width of the Like button.
    action - the verb to display on the button. Options: 'like', 'recommend'
    font - the font to display in the button. Options: 'arial', 'lucida grande', 'segoe ui', 'tahoma', 'trebuchet ms', 'verdana'
    colorscheme - the color scheme for the like button. Options: 'light', 'dark'
    ref - a label for tracking referrals; must be less than 50 characters and can contain alphanumeric characters and some punctuation (currently +/=-.:_). The ref attribute causes two parameters to be added to the referrer URL when a user clicks a link from a stream story about a Like action:
        fb_ref - the ref parameter
        fb_source - the stream type ('home', 'profile', 'search', 'other') in which the click occurred and the story type ('oneline' or 'multiline'), concatenated with an underscore.


<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fmysite.ru&amp;layout=button_count&amp;show_faces=false&amp;width=200&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:21px;" allowTransparency="true"></iframe>

 */
class fbLikeWidget extends CWidget
{
	/**
	 * Url for like
	 * @var string
	 */
	public $href = '';

	public $layout = 'standard';

	public $show_faces = false;
	public $width = 200;
	public $action = 'like';
	public $font = 'arial';
	public $colorscheme = 'light';

	public function run()
	{
		$src = 'http://www.facebook.com/plugins/like.php?';

		$this->href = $this->href
			? $this->href
			: Y::request()->getRequestUri();

		$urlA = array();
		foreach(array('href','layout','width','action','font','colorscheme') as $field)
			$urlA[] = $field.'='.$this->$field;

		$url = implode('&', $urlA);

		$src .= htmlspecialchars($url, ENT_COMPAT, 'UTF-8');

		echo CHtml::tag('iframe', array(
			'src'=>$src,
			'scrolling'=>"no",
			'frameborder'=>"0",
			'style'=>"border:none; overflow:hidden; width:200px; height:21px;",
			'allowTransparency'=>"true",
		), '', true);
	}

	/**
	 * Rate counter
	 * @param string $url
	 */
	public static function getRate($url)
	{
		if (!($request = file_get_contents('http://graph.facebook.com/'.$url)))
            return false;
        $fb = json_decode($request);
        return ($fb===NULL OR !isset($fb->shares))?0:$fb->shares;
	}
}