<?php
/**
 * @author Никита
 * @date 02/03/17
 */

namespace site\frontend\modules\geo2\components\fias;


class ArchiveGetter
{
    public $destination;
    
    public function __construct($destination)
    {
        $this->destination = $destination;
    }

    public function get()
    {
        $archive = $this->download($this->destination);
        return $this->unrar($archive);
    }

    protected function unrar($path)
    {
        if (!`which unrar`) {
            throw new \CException('Unrar is not installed');
        }

        $deltaPath = $this->getPath();
        if (! is_dir($deltaPath)) {
            mkdir($deltaPath);
        } else {
            foreach (new \DirectoryIterator($deltaPath) as $file) {
                if ($file->isDot()) {
                    continue;
                }
                unlink($file->getPathname());
            }
        }
        shell_exec("unrar e -r $path $deltaPath");
        
        return $deltaPath;
    }

    protected function getPath()
    {
        return \Yii::app()->getRuntimePath() . DIRECTORY_SEPARATOR . md5($this->destination);
    }

    protected function download($url)
    {
        $filename = substr($url, strrpos($url, '/'));
        $path = \Yii::app()->getRuntimePath() . DIRECTORY_SEPARATOR . $filename;
        file_put_contents($path, fopen($url, 'r'));
        return $path;
    }
}