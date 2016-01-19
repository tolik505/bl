</div>
</div>
<!-- End Content -->

<!-- Start Footer -->
<footer>
    <div class="container">
        <div class="row footer-widgets">

            <?= \frontend\widgets\footerSitemap\FooterSitemapWidget::widget() ?>

            <!-- Start Subscribe & Social Links Widget -->
            <div class="col-md-3">
                <?= $this->render('_subscribe_form', ['model' => new \common\models\MailRequest()]) ?>
                <?php /* <div class="footer-widget social-widget">
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
                </div> */?>
            </div>
        </div>
        <!-- End Subscribe & Social Links Widget -->

        <!-- Start Copyright -->
        <div class="copyright-section">
            <div class="row">
                <div class="col-md-6">
                    <p>© 2016 BL -  All Rights Reserved</p>
                </div>
                <?php /* <div class="col-md-6">
                    <ul class="footer-nav">
                        <li><a href="#">Sitemap</a></li>
                    </ul>
                </div> */ ?>
            </div>
        </div>
        <!-- End Copyright -->

    </div>
</footer>
<!-- End Footer -->
