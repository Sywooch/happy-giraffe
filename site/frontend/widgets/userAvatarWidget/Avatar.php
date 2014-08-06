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

    public function run()
    {
        switch($this->size) {
            case self::SIZE_MICRO:
            case self::SIZE_SMALL:
            case self::SIZE_MEDIUM:
                $class = 'ava';
                switch ($this->size) {
                    case self::SIZE_MICRO:
                        $class .= ' ava__small';
                        break;
                    case self::SIZE_SMALL:
                        $class .= ' ava__middle';
                        break;
                }


                $class .= ' ava__' . (($this->user->gender == 0) ? 'female' : 'male');
                $tag = $this->user->deleted == 1 ? 'span' : 'a';
                if (isset($this->htmlOptions['class'])) {
                    $class .= ' ' . $this->htmlOptions['class'];
                    unset($this->htmlOptions['class']);
                }
                $options = CMap::mergeArray(array(
                    'class' => $class,
                ), $this->htmlOptions);
                if ($this->user->deleted == 0) {
                    $options['href'] = $this->user->getUrl();
                }
                $this->render('simple', compact('tag', 'options'));
                break;
            case self::SIZE_LARGE:
                $this->render('200');
                break;
            default:
                throw new CException('Неподдерживаемый размер аватары');
        }
    }
}