<div class="services">
    <ul class="auth-services clear">
        <?php
        foreach ($services as $name => $service) {
            if ($this->mode && $this->mode == 'profile') {
                if(($check = UserSocialService::model()->findByUser($name, Yii::app()->user->id)) != null)
                {
                    echo '<li>';
                    $html = '<div class="line-title">' . $service->title . '</div>';
                    $html .= '<span class="auth-icon ' . $service->id . '"><i></i></span>';
                    $html .= '<p>' . CHtml::link('Отключить', array('/profile/disableSocialService', 'name' => $name)) . '</p>';
                    $html = '<li class="clearfix">
                            <div class="img-box">
                                <img src="/images/ava.png">
                                <label class="vk"></label>
                                <a class="remove" href=""></a>
                            </div>
                            <span class="name">Дарья Петрова</span>
                        </li>';
                }
                else
                {
                    echo '<li>';
                    $html = '<div class="line-title">' . $service->title . '</div>';
                    $link_text = '<span class="auth-icon ' . $service->id . '"><i></i></span>';
                    $html .= CHtml::link($link_text, array($action, 'service' => $name), array(
                        'class' => 'auth-link ' . $service->id,
                    ));
                }
            }
            else
            {
                echo '<li class="auth-service ' . $service->id . '">';
                $html = '<span class="auth-icon ' . $service->id . '"><i></i></span>';
                $html .= '<span class="auth-title">' . $service->title . '</span>';
                $html = CHtml::link($html, array($action, 'service' => $name), array(
                    'class' => 'auth-link ' . $service->id,
                ));
            }
            echo $html;

            echo '</li>';
        }
        ?>
    </ul>
</div>