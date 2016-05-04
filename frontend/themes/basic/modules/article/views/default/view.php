<?php
/**
 * @var $this \yii\web\View
 * @var $model \frontend\modules\article\models\Article
 */
use \metalguardian\fileProcessor\helpers\FPM;

$titleImage = $model->titleImage;
?>

<?= $this->render('@app/themes/basic/layouts/_header', ['breadcrumbsLinks' => $model->getBreadcrumbsLinks()]) ?>

<div class="row blog-post-page">
    <div class="col-md-9 blog-box">

        <!-- Start Single Post Area -->
        <div class="blog-post gallery-post">

            <!-- Post Thumb -->
            <div class="post-head">
                <?php if (isset($titleImage->file_id)) { ?>
                    <?= FPM::image($titleImage->file_id, 'article', 'title', ['alt' => $model->label]) ?>
                <?php } ?>
            </div>

            <!-- Start Single Post Content -->
            <div class="post-content">
                <div class="post-type"><i class="icon-pencil-4"></i></div>
                <h2><?= $model->label ?></h2>
                <ul class="post-meta">
                    <li><?= Yii::$app->formatter->asDate($model->date, 'dd MMMM yyyy') ?></li>
                    <?php $categoryLabel = $model->getCategoryLabel() ?>
                    <?php if ($categoryLabel) { ?>
                        <li><a href="<?= $model->getCategoryUrl() ?>"><?= $categoryLabel ?></a></li>
                    <?php } ?>
                    <li><a href="#comments"><?= $model->getCommentsCount() ?> <?= Yii::t('app', 'Comments') ?></a></li>
                </ul>
                <p><?= $model->content ?></p>

                <div class="post-bottom clearfix">
                    <?= \frontend\modules\article\widgets\articleTags\ArticleTagsWidget::widget(['model' => $model]) ?>
                    <?=  \ijackua\sharelinks\ShareLinks::widget([
                            'viewName' => '//layouts/social-shares',
                            'linkSelector' => '.post-share a'
                        ]
                    ); ?>
                </div>
            </div>
            <!-- End Single Post Content -->

        </div>
        <!-- End Single Post Area -->

    <?= $this->render('_comments', ['model' => $model]) ?>

    </div>

    <?= $this->renderFile($this->theme->getPath('layouts/_side-bar.php')) ?>
</div>
<?= $this->render('@app/themes/basic/layouts/_footer') ?>
