<?php
/**
 * @author Никита
 * @date 02/03/17
 */

namespace site\frontend\modules\geo2\components\fias\update;


class DeltaGetter
{
    const DELTA_DESTIONATION = 'http://fias.nalog.ru/Public/Downloads/Actual/fias_delta_xml.rar';
    const RUNTIME_PATH = 'fias_delta';

    public function getDelta()
    {
        $archive = $this->download();
        return $this->unrar($archive);
    }

    protected function unrar($path)
    {
        if (!`which unrar`) {
            throw new \CException('Unrar is not installed');
        }

        $deltaPath = $this->getDeltaPath();
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

    protected function getDeltaPath()
    {
        return \Yii::app()->getRuntimePath() . DIRECTORY_SEPARATOR . self::RUNTIME_PATH;
    }

    protected function download()
    {
        $filename = substr(self::DELTA_DESTIONATION, strrpos(self::DELTA_DESTIONATION, '/'));
        $path = \Yii::app()->getRuntimePath() . DIRECTORY_SEPARATOR . $filename;
        file_put_contents($path, fopen(self::DELTA_DESTIONATION, 'r'));
        return $path;
    }
}