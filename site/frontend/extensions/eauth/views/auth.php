<div class="services">
  <ul class="auth-services clear">
  <?php
	foreach ($services as $name => $service) {
        if($this->mode && $this->mode == 'profile' && ($check = UserSocialService::model()->findByUser($name, Yii::app()->user->id)) != null)
        {
                echo '<li class="auth-service">';
                $html = '<span class="auth-icon '.$service->id.'"><i></i></span>';
                $html .= '<span class="auth-title">'.$service->title.'</span>';
                $html .= '<p>' . CHtml::link('Отключить', array('/profile/disableSocialService', 'name' => $name)) . '</p>';
        }
        else
        {
            echo '<li class="auth-service '.$service->id.'">';
            $html = '<span class="auth-icon '.$service->id.'"><i></i></span>';
            $html .= '<span class="auth-title">'.$service->title.'</span>';
            $html = CHtml::link($html, array($action, 'service' => $name), array(
                'class' => 'auth-link '.$service->id,
            ));
        }
        echo $html;
        
		echo '</li>';
	}
  ?>
  </ul>
</div>