<div class="text" id="location-title"><?=$post->photoPost->location ?></div><br>
<img src="<?= $post->photoPost->getImageUrl() ?>" alt="" id="location-img">

<a href="<?=$this->createUrl('morning/location', array('id'=>$post->id)) ?>" class="edit fancy"><span class="tip">Редактировать локацию</span></a>
<a href="javascript:void(0);" onclick="Morniing.removeLocation(this)" class="remove"><span class="tip">удалить локацию</span></a>
