<?php
/** @var $models ArticleCategory[] */
/** @var $md integer */

use frontend\modules\article\models\ArticleCategory;
?>
<?php foreach($models as $category): ?>
    <div class="col-md-<?= $md ?>">
        <div class="footer-widget">
            <h4>
                <a href="<?= $category->getIndexUrl() ?>"><?= $category->label ?></a>
                <span class="head-line"></span>
            </h4>
            <ul>
                <?php foreach($category->articles as $article): ?>
                    <li><a href="<?= $article->getViewUrl() ?>"><?= $article->label ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endforeach; ?>
