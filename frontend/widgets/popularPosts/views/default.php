<?php
/**
 * @var $models \frontend\modules\article\models\Article[]
 */

use \metalguardian\fileProcessor\helpers\FPM;
?>

<div class="widget widget-popular-posts">
    <h4><?= Yii::t('app', 'Popular Post') ?> <span class="head-line"></span></h4>
    <ul>
        <?php foreach($models as $article): ?>
            <li>
                <?php $titleImage = $article->titleImage; ?>
                <?php $url = $article->getViewUrl(); ?>
                <div class="widget-thumb">
                    <a href="<?= $url ?>"><?= FPM::image($titleImage->file_id, 'article', 'thumb', ['alt' => $article->label]) ?></a>
                </div>
                <div class="widget-content">
                    <h5><a href="<?= $url ?>"><?= $article->label ?></a></h5>
                    <span><?= Yii::$app->formatter->asDate($article->date, 'd MMM yyyy') ?></span>
                </div>
                <div class="clearfix"></div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
