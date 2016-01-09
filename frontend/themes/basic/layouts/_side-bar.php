<!--Sidebar-->
<div class="col-md-3 sidebar right-sidebar">

    <!-- Search Widget -->
    <div class="widget widget-search">
        <form action="#">
            <input type="search" placeholder="Enter Keywords..." />
            <button class="search-btn" type="submit"><i class="icon-search-1"></i></button>
        </form>
    </div>


    <?= \frontend\widgets\popularPosts\PopularPostsWidget::widget() ?>


    <?= \frontend\widgets\tags\TagsWidget::widget() ?>

</div>
<!--End sidebar-->
