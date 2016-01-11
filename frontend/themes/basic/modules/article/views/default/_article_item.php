<?php
/**
 * @var $model \frontend\modules\article\models\Article
 */
use \metalguardian\fileProcessor\helpers\FPM;

$titleImage = $model->titleImage;
$viewUrl = $model->getViewUrl();
?>
<!-- Start Post -->
<div class="blog-post standard-post">
    <!-- Post Thumb -->
    <div class="post-head">
        <a href="<?= $viewUrl ?>">
            <div class="thumb-overlay"><i class="icon-link"></i></div>
            <?php if (isset($titleImage->file_id)) { ?>
                <?= FPM::image($titleImage->file_id, 'article', 'title', ['alt' => $model->label]) ?>
            <?php } ?>
        </a>
    </div>
    <!-- Post Content -->
    <div class="post-content">
        <div class="post-type"><i class="icon-pencil-4"></i></div>
        <h2><a href="<?= $viewUrl ?>"><?= $model->label ?></a></h2>
        <ul class="post-meta">
            <li><?= Yii::$app->formatter->asDate($model->date, 'dd MMMM yyyy') ?></li>
            <?php $categoryLabel = $model->getCategoryLabel() ?>
            <?php if ($categoryLabel) { ?>
                <li><a href="<?= $model->getCategoryUrl() ?>"><?= $categoryLabel ?></a></li>
            <?php } ?>
            <li><a href="<?= $model->getViewUrl(['#' => 'comments']) ?>"><?= $model->getCommentsCount() ?> <?= Yii::t('app', 'Comments') ?></a></li>
        </ul>
        <p><?= $model->getAnnounce() ?></p>
        <a class="main-button" href="<?= $viewUrl ?>"><?= Yii::t('app', 'Read More') ?> <i class="icon-right-small"></i></a>
    </div>
</div>
<!-- End Post -->
