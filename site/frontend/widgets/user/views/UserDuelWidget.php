<div class="user-duel">

    <div class="box-title">Моя <span>дуэль</span></div>

    <div class="question">
        <p><?=$this->question->text?></p>
    </div>

    <div class="my-votes clearfix">
        <?php
            $class = 'ava';
            if ($this->user->gender !== null) $class .= ' ' . (($this->user->gender) ? 'male' : 'female');
        ?>
        <?=CHtml::link(CHtml::image($this->user->ava), $this->user->url, array('class' => $class))?>
        <div class="in">
            <span class="tale"></span>
            <?php if ($this->myAnswer->votes < $this->opponentAnswer->votes): ?>
                <div class="label">Увы, проигрываю!</div>
                <img src="/images/user_duel_smile_losing.png" />
            <?php endif; ?>
            <?php if ($this->myAnswer->votes > $this->opponentAnswer->votes): ?>
                <div class="label">Ура, выигрываю!</div>
                <img src="/images/user_duel_smile_winning.png" />
            <?php endif; ?>
            <?php if ($this->myAnswer->votes == $this->opponentAnswer->votes): ?>
                <div class="label">Пока ничья...</div>
                <img src="/images/user_duel_smile_draw.png" />
            <?php endif; ?>
            <div class="count">
                <span><?=$this->myAnswer->votes?></span>
                голосов
            </div>
            <br/>
            <?=HHtml::link('Посмотреть дуэль', array('ajax/duelShow', 'question_id' => $this->question->id), array('class' => 'pseudo fancy'), true)?>
        </div>
    </div>

    <div class="opponent clearfix">
        Мой противник
        <div class="count">
            <span><?=$this->opponentAnswer->votes?></span>
            голосов
        </div>
        <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $this->opponentAnswer->user, 'size' => 'small', 'location' => false, 'sendButton' => false)); ?>
    </div>

</div>