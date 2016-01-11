<!--Sidebar-->
<div class="col-md-3 sidebar right-sidebar">

    <!-- Search Widget -->
    <div class="widget widget-search">
        <form class="search-form" action="#" data-url="<?= \frontend\modules\article\models\Article::getSearchUrl() ?>">
            <input type="search" placeholder="<?= Yii::t('app', 'Enter Keywords') ?>..." />
            <button class="search-btn" type="submit"><i class="icon-search-1"></i></button>
            <a href="#"></a>
        </form>
    </div>


    <?= \frontend\widgets\popularPosts\PopularPostsWidget::widget() ?>


    <?= \frontend\widgets\tags\TagsWidget::widget() ?>

</div>
<!--End sidebar-->
