<?php
/** @var $breadcrumbsLinks array */
?>
<!-- Start Header -->
<div class="hidden-header"></div>
<header class="clearfix">

    <!-- Start Header ( Logo & Naviagtion ) -->
    <div class="navbar navbar-default navbar-top">
        <div class="container">
            <div class="navbar-header">
                <!-- Stat Toggle Nav Link For Mobiles -->
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <i class="icon-menu-1"></i>
                </button>
                <!-- End Toggle Nav Link For Mobiles -->
                <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">
                    <img src="<?= $this->theme->getUrl('images/logo_grey.png') ?>">
                </a>
            </div>
            <div class="navbar-collapse collapse">
                <?= \frontend\widgets\LanguageChecker::widget() ?>
                <?= \frontend\widgets\mainMenu\MainMenuWidget::widget() ?>
            </div>
        </div>
    </div>
    <!-- End Header ( Logo & Naviagtion ) -->

</header>
<!-- End Header -->

<!-- Start Page Banner -->
<div class="page-banner">
    <div class="container">
        <div class="row">
            <div class="col-md-6">

            </div>
            <div class="col-md-6 breadcrumbs-div">
                <?php if ($breadcrumbsLinks) { ?>
                    <?= \frontend\components\CustomBreadcrumbs::widget([
                        'links' => $breadcrumbsLinks,
                    ]) ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- End Page Banner -->

<!-- Start Content -->
<div id="content">
    <div class="container">
