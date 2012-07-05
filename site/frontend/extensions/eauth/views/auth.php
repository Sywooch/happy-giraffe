<div class="services">
    <ul class="auth-services">
        <?php
        foreach ($services as $name => $service) {
            if ($this->mode && $this->mode == 'profile') {
                if(($check = UserSocialService::model()->findByUser($name, Yii::app()->user->id)) != null)
                {
                    echo '<li>';
                    echo '<li class="clearfix">
                            <div class="img-box">';
                    $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => Yii::app()->user->model, 'small' => true));
                    echo '<label class="' . $service->id . '"></label>
                            ' . HHtml::link('', array('/profile/disableSocialService', 'name' => $name), array('class' => 'remove'), true) . '
                        </div>
                        <span class="name">' . Yii::app()->user->model->fullName . '</span>
                    </li>';
                    $html = '';
                }
                else
                {
                    echo '<li>';
                    $html = '<div class="line-title">' . $service->title . '</div>';
                    $link_text = '<span class="auth-icon ' . $service->id . '"><i></i></span>';
                    $html .= HHtml::link($link_text, array($action, 'service' => $name), array(
                        'class' => 'auth-link ' . $service->id,
                    ), true);
                }
            }
            else
            {
                echo '<li class="auth-service ' . $service->id . '">';
                $html = '<span class="auth-icon ' . $service->id . '"><i></i></span>';
                $html .= '<span class="auth-title">' . $service->title . '</span>';
                $html = HHtml::link($html, array($action, 'service' => $name), array(
                    'class' => 'auth-link ' . $service->id,
                ), true);
            }
            echo $html;

            echo '</li>';
        }
        ?>
    </ul>
</div>