<?php

class Avatar extends CWidget
{
    const SIZE_MICRO = 24;
    const SIZE_SMALL = 40;
    const SIZE_MEDIUM = 72;
    const SIZE_LARGE = 200;

    /**
     * @var User
     */
    public $user;
    /**
     * @var string
     */
    public $size = self::SIZE_MEDIUM;
    public $location = false;
    public $age = false;
    public $message_link = true;
    public $blog_link = true;
    public $htmlOptions = array();
    public $tag = null;
    public $largeAdvanced = true;

    public function run()
    {
        if ($this->size == self::SIZE_LARGE && $this->largeAdvanced === true) {
            $this->render('200');
        } else {
            $class = 'ava';
            switch ($this->size) {
                case self::SIZE_MICRO:
                    $class .= ' ava__small';
                    break;
                case self::SIZE_SMALL:
                    $class .= ' ava__middle';
                    break;
                case self::SIZE_LARGE:
                    $class .= ' ava__large';
                    break;
            }


            $class .= ' ava__' . (($this->user->gender == 0) ? 'female' : 'male');
            if ($this->tag === null) {
                $tag = $this->user->deleted == 1 ? 'span' : 'a';
            } else {
                $tag = $this->tag;
            }
            if (isset($this->htmlOptions['class'])) {
                $class .= ' ' . $this->htmlOptions['class'];
                unset($this->htmlOptions['class']);
            }
            $options = CMap::mergeArray(array(
                'class' => $class,
            ), $this->htmlOptions);
            if ($tag == 'a') {
                $options['href'] = $this->user->getUrl();
            }
            $this->render('simple', compact('tag', 'options'));
        }
    }
}