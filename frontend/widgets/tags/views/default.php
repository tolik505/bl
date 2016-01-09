<div class="widget widget-tags">
    <h4><?= Yii::t('app', 'Tags') ?> <span class="head-line"></span></h4>
    <div class="tagcloud">
        <?php
        echo \justinvoelker\tagging\TaggingWidget::widget([
            'items' => $tags,
            'smallest' => 12,
            'largest' => 12,
            'url' => [\frontend\modules\article\models\Article::getSearchRoute()],
            'urlParam' => 'query'
        ]);
        ?>
    </div>
</div>
