<?php
use yii\helpers\Html;
use frontend\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="icon" type="image/png" href="<?= $this->theme->getUrl('img/png/favicon.png') ?>" />
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <!-- Container -->
    <div id="container" class="boxed-page">
        <?php \yii\widgets\Pjax::begin([
            'timeout' => 3000,
        ]) ?>
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
                        <div class="search-side">
                            <a href="#" class="show-search"><i class="icon-search-1"></i></a>
                            <div class="search-form">
                                <form autocomplete="off" role="search" method="get" class="searchform" action="#">
                                    <input type="text" value="" name="s" id="s" placeholder="Search the site...">
                                </form>
                            </div>
                        </div>
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
                    <div class="col-md-6">
                        <?php if (isset($this->blocks['breadcrumbs'])): ?>
                            <?= $this->blocks['breadcrumbs'] ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Banner -->

        <!-- Start Content -->
        <div id="content">
            <div class="container">

                <?= $content ?>

            </div>
        </div>
        <!-- End Content -->

        <!-- Start Footer -->
        <footer>
            <div class="container">
                <div class="row footer-widgets">

                    <!-- Start Contact Widget -->
                    <div class="col-md-3">
                        <div class="footer-widget contact-widget">
                            <h4>Contact info<span class="head-line"></span></h4>
                            <ul>
                                <li><span>Address:</span> 1234 Street Name, City Name, Egypt</li>
                                <li><span>Phone Number:</span> +01 234 567 890</li>
                                <li><span>Fax Number:</span> +01 234 567 890</li>
                                <li><span>Email:</span> company@company.com</li>
                                <li><span>Website:</span> www.yourdomain.com</li>
                            </ul>
                        </div>
                    </div>
                    <!-- End Contact Widget -->

                    <!-- Start Flickr Widget -->
                    <div class="col-md-3">
                        <div class="footer-widget flickr-widget">
                            <h4>Flicker Feed<span class="head-line"></span></h4>
                            <!--<ul class="flickr-list">
                                <li>
                                    <a href="#"><img alt="" src="images/flickr-01.jpg"></a>
                                </li>
                                <li>
                                    <a href="#"><img alt="" src="images/flickr-02.jpg"></a>
                                </li>
                                <li>
                                    <a href="#"><img alt="" src="images/flickr-03.jpg"></a>
                                </li>
                                <li>
                                    <a href="#"><img alt="" src="images/flickr-04.jpg"></a>
                                </li>
                                <li>
                                    <a href="#"><img alt="" src="images/flickr-05.jpg"></a>
                                </li>
                                <li>
                                    <a href="#"><img alt="" src="images/flickr-06.jpg"></a>
                                </li>
                                <li>
                                    <a href="#"><img alt="" src="images/flickr-07.jpg"></a>
                                </li>
                                <li>
                                    <a href="#"><img alt="" src="images/flickr-08.jpg"></a>
                                </li>
                                <li>
                                    <a href="#"><img alt="" src="images/flickr-09.jpg"></a>
                                </li>
                            </ul>-->
                        </div>
                    </div>
                    <!-- End Flickr Widget -->

                    <!-- Start Twitter Widget -->
                    <div class="col-md-3">
                        <div class="footer-widget twitter-widget">
                            <h4>Twitter Feed<span class="head-line"></span></h4>
                            <ul>
                                <li>
                                    <p><a href="#">@RoberdKS </a> Lorem ipsum dolor et, consectetur adipiscing eli.</p>
                                    <span>29 September 2013</span>
                                </li>
                                <li>
                                    <p><a href="#">@RoberdKS </a> Lorem ipsum dolor et, consectetur adipiscing eli.An Fusce eleifend aliquet nis application.</p>
                                    <span>26 September 2013</span>
                                </li>
                                <li>
                                    <p><a href="#">@RoberdKS </a> Lorem ipsum dolor et, consectetur adipiscing eli.</p>
                                    <span>29 September 2013</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- End Twitter Widget -->

                    <!-- Start Subscribe & Social Links Widget -->
                    <div class="col-md-3">
                        <div class="footer-widget mail-subscribe-widget">
                            <h4>Get in touch<span class="head-line"></span></h4>
                            <p>Join our mailing list to stay up to date and get notices about our new releases!</p>
                            <form class="subscribe">
                                <input type="text" placeholder="mail@example.com">
                                <input type="submit" class="main-button" value="Send">
                            </form>
                        </div>
                        <div class="footer-widget social-widget">
                            <h4>Follow Us<span class="head-line"></span></h4>
                            <ul class="social-icons">
                                <li>
                                    <a class="facebook" href="#"><i class="icon-facebook-2"></i></a>
                                </li>
                                <li>
                                    <a class="twitter" href="#"><i class="icon-twitter-2"></i></a>
                                </li>
                                <li>
                                    <a class="google" href="#"><i class="icon-gplus-1"></i></a>
                                </li>
                                <li>
                                    <a class="dribbble" href="#"><i class="icon-dribbble-2"></i></a>
                                </li>
                                <li>
                                    <a class="linkdin" href="#"><i class="icon-linkedin-1"></i></a>
                                </li>
                                <li>
                                    <a class="flickr" href="#"><i class="icon-flickr-1"></i></a>
                                </li>
                                <li>
                                    <a class="tumblr" href="#"><i class="icon-tumblr-1"></i></a>
                                </li>
                                <li>
                                    <a class="instgram" href="#"><i class="icon-instagramm"></i></a>
                                </li>
                                <li>
                                    <a class="vimeo" href="#"><i class="icon-vimeo"></i></a>
                                </li>
                                <li>
                                    <a class="skype" href="#"><i class="icon-skype-2"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- End Subscribe & Social Links Widget -->

                <!-- Start Copyright -->
                <div class="copyright-section">
                    <div class="row">
                        <div class="col-md-6">
                            <p>© 2013 Venda -  All Rights Reserved</p>
                        </div>
                        <div class="col-md-6">
                            <ul class="footer-nav">
                                <li><a href="#">Sitemap</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- End Copyright -->

            </div>
        </footer>
        <!-- End Footer -->

    </div>
    <!-- End Container -->

    <!-- Go To Top Link -->
    <a href="#" class="back-to-top"><i class="icon-up-open-1"></i></a>

    <div id="loader">
        <div class="spinner">
            <div class="dot1"></div>
            <div class="dot2"></div>
        </div>
    </div>
    <?php \yii\widgets\Pjax::end() ?>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
