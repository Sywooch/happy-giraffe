<div class="text" id="location-title"><?=$post->morning->location ?></div><br>
<img src="<?= $post->morning->getImageUrl() ?>" alt="" id="location-img">

<a href="<?=$this->createUrl('morning/location', array('id'=>$post->id)) ?>" class="edit fancy toolttip" title="Редактировать локацию"></a>
<a href="javascript:void(0);" onclick="Morniing.removeLocation(this)" class="remove tooltip" title="удалить локацию"></a>