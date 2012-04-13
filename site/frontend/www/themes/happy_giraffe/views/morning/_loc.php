<div class="text"><?=$post->photoPost->location ?></div><br>
<img src="<?= $post->photoPost->getImageUrl() ?>" alt="">

<a href="<?=$this->createUrl('morning/location', array('id'=>$post->id)) ?>" class="edit fancy"><span class="tip">Редактировать название</span></a>