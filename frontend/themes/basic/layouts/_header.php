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
                <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">BL</a>
            </div>
            <div class="navbar-collapse collapse">
                <!-- Stat Search -->
                <!--<div class="search-side">
                    <a href="#" class="show-search"><i class="icon-search-1"></i></a>
                    <div class="search-form">
                        <form autocomplete="off" role="search" method="get" class="searchform" action="#">
                            <input type="text" value="" name="s" id="s" placeholder="Search the site...">
                        </form>
                    </div>
                </div>-->
                <!-- End Search -->
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
                <h2>Blog</h2>
                <p>Blog Page With Right Sidebar</p>
            </div>
            <?php if ($breadcrumbsLinks) { ?>
                <div class="col-md-6">
                    <?= \frontend\components\CustomBreadcrumbs::widget([
                        'links' => $breadcrumbsLinks,
                    ]) ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- End Page Banner -->

<!-- Start Content -->
<div id="content">
    <div class="container">
