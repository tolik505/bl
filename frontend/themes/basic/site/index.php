<?php
/* @var $this yii\web\View */
/* @var $dataProvider */
?>
<div class="row blog-page">

    <!-- Start Blog Posts -->
    <div class="col-md-9 blog-box">
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
