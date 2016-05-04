<?php
use ijackua\sharelinks\ShareLinks;
?>
<div class="post-share">
    <span><?= Yii::t('app', 'Share This Post') ?>:</span>
    <a class="facebook" href="<?= $this->context->shareUrl(ShareLinks::SOCIAL_FACEBOOK) ?>"><i class="icon-facebook"></i></a>
    <a class="twitter" href="<?= $this->context->shareUrl(ShareLinks::SOCIAL_TWITTER) ?>"><i class="icon-twitter"></i></a>
    <a class="gplus" href="<?= $this->context->shareUrl(ShareLinks::SOCIAL_GPLUS) ?>"><i class="icon-gplus"></i></a>
    <?php /*<a class="linkedin" href="<?= $this->context->shareUrl(ShareLinks::SOCIAL_LINKEDIN) ?>"><i class="icon-linkedin-1"></i></a>*/ ?>
    <a class="vkontakte" href="<?= $this->context->shareUrl(ShareLinks::SOCIAL_VKONTAKTE) ?>"><i class="icon-vkontakte"></i></a>
</div>
