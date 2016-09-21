<?php 

use site\frontend\modules\users\models\User;

$classGender = USER::GENDER_MALE == $user->gender ? 'male' : 'female';

?>

<a href="<?= $user->profileUrl ?>" class="ava ava__<?php echo $classGender; ?> ava__middle-sm">
	<span class="ico-status ico-status__online"></span>
	<img alt="" src="<?= $user->avatarUrl ?>" class="ava_img">
</a>

<a href="<?= $user->profileUrl ?>" class="b-article_author"><?= $user->fullName ?></a>

<?php if ($user->specInfo !== null): ?>
    <div class="b-article_authorpos"><?=$user->specInfo['title']?></div>
<?php endif; ?>