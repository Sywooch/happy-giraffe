<?php
/**
 * Class OptimisationCommand
 *
 * Консольные команды по различной оптимизации
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class OptimisationCommand extends CConsoleCommand
{
    public function actionAvatars(){
        Yii::import('site.frontend.extensions.EPhpThumb.*');
        for($i=10000;$i<=80000;$i++){
            $user = User::model()->findByPk($i);
            if ($user !== null && !empty($user->avatar_id)){
                $photo = $user->avatar;
                $file_name = $photo->getAvatarPath('small');
                $image = new EPhpThumb();
                $image->init(); //this is needed
                $image = $image->create($file_name);
                $image->save($file_name);

                $file_name = $photo->getAvatarPath('ava');
                $image = new EPhpThumb();
                $image->init(); //this is needed
                $image = $image->create($file_name);
                $image->save($file_name);
            }

            if ($i % 100 == 0)
                echo $i;
        }
    }
}
