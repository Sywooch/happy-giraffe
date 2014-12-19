<?php

namespace site\frontend\modules\photo\behaviors;

/**
 * @author Никита
 * @date 19/12/14
 */

class FsBehavior extends \CBehavior
{
    /** @var \Gaufrette\Filesystem */
    public $fs;
    public $prefix;
    public $fsName;

    protected $file;

    /**
     * @return \Gaufrette\File
     */
    public function getFile()
    {
        if ($this->file === null) {
            $this->file = $this->fs->createFile($this->getPath());
        }
        return $this->file;
    }

    protected function getPath()
    {
        if (is_callable($this->fsName)) {
            $fsName = call_user_func($this->fsName, array('owner' => $this->owner));
        } elseif (property_exists($this->owner, $this->fsName)) {
            $fsName = $this->owner->{$this->fsName};
        } else {
            $fsName = $this->fsName;
        }
        return (($this->prefix) ? $this->prefix . '/' : '') . $fsName;
    }
} 