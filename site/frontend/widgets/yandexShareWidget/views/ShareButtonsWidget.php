<style>
.share-buttons {
    text-align: center;
}

.share-buttons_i {
    margin: 0 2px;
    display: inline-block;
    vertical-align: middle;
}

.share-buttons_vk * {
    box-sizing: content-box;
}
</style>

<div class="share-buttons">
    <span id="VkShare_<?=$this->id?>" class="share-buttons_i share-buttons_vk"></span>
    <span class="share-buttons_i share-buttons_fb fb-share-button" data-href="<?=$this->url?>" data-layout="button_count"></span>
</div>