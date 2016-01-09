<?php
/**
 * @var $tags array
 */
?>
<div class="post-tags-list">
    <?php foreach($tags as $tag): ?>
        <a href="<?= \frontend\modules\article\models\Article::getSearchUrl(['query' => $tag]) ?>"><?= $tag ?></a>
    <?php endforeach; ?>
</div>
