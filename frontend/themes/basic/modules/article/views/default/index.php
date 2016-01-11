<?php
/* @var $this yii\web\View */
/* @var $dataProvider */
/* @var $query string */
/* @var $categoryLabel string */

$breadcrumbsLinks = isset($categoryLabel) ?
    [
        [
            'label' => $categoryLabel
        ]
    ] :
    null
?>

<?= $this->render('@app/themes/basic/layouts/_header', [
    'breadcrumbsLinks' => $breadcrumbsLinks
]) ?>

<div class="row blog-page">
    <!-- Start Blog Posts -->
    <div class="col-md-9 blog-box">
        <?php if (isset($query)) { ?>
            <h1 class="list-title"><?= Yii::t('app', 'Search by word') ?> "<?= $query ?>"</h1>
        <?php } ?>
        <?= \yii\widgets\ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_article_item',
            'itemOptions' => ['tag' => false],
            'layout' => "{items}",
        ]); ?>

        <?= \frontend\components\LinkPager::widget([
            'pagination' => $dataProvider->pagination,
        ]) ?>
    </div>
    <!-- End Blog Posts -->

<?= $this->renderFile($this->theme->getPath('layouts/_side-bar.php')) ?>
</div>
<?= $this->render('@app/themes/basic/layouts/_footer') ?>
