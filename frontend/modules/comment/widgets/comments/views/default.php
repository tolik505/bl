<?php
/* @var $this yii\web\View */
/**
 * @var $commentModel \common\models\Comment
 * @var $commentModels \common\models\Comment[]
 * @var $child \common\models\Comment
 * @var $model \frontend\modules\article\models\Article
 */
?>
<!-- Start Comment Area -->
<div id="comments">
    <h2 class="comments-title">(<?= $model->getCommentsCount() ?>) <?= Yii::t('app', 'Comments') ?></h2>
    <ol class="comments-list">
        <li>
        <?php foreach($commentModels as $key => $comment): ?>
            <div class="comment-box clearfix">
                <div class="avatar"><img alt="" src="<?= $this->theme->getUrl('/images/avatar.png') ?>" /></div>
                <div class="comment-content">
                    <div class="comment-meta">
                        <span class="comment-by"><?= $comment->name ?></span>
                        <span class="comment-date"><?= Yii::$app->formatter->asDatetime($comment->created_at, 'd MMMM yyyy, HH:mm') ?></span>
                        <span class="reply-link"><a href="#" data-id="<?= $comment->id ?>"><?= Yii::t('app', 'Reply') ?></a></span>
                    </div>
                    <p><?= $comment->content ?></p>
                </div>
            </div>
            <?php if (isset($commentModels[$key + 1]) && $commentModels[$key + 1]->depth > $comment->depth) { ?>
                <ul><li>
            <?php } ?>
            <?php if ((isset($commentModels[$key + 1]) && $commentModels[$key + 1]->depth < $comment->depth)) { ?>
            	<?php for ($i = $commentModels[$key + 1]->depth; $i < $comment->depth; $i++) { ?>
                    </li></ul>
                <?php } ?>
            <?php } ?>
            <?php if (($comment->depth > 1 && !isset($commentModels[$key + 1]))) { ?>
                </li></ul>
            <?php } ?>
        <?php endforeach; ?>
        </li>
    </ol>

    <!-- Start Respond Form -->
    <div id="respond">
        <h2 class="respond-title"><?= Yii::t('app', 'Leave a reply') ?></h2>
        <?php
        $form = \yii\widgets\ActiveForm::begin([
            'action' => \common\models\Comment::getAddCommentUrl(),
            'options' => [
                'id' =>'comment-form',
                'class' => 'ajax-form'
            ]
        ]);
        echo \yii\helpers\Html::hiddenInput('parent_id', 0, ['class' => 'parent_id']);
        echo $form->field($commentModel, 'model_name')->hiddenInput(['value' => $model->formName()]);
        echo $form->field($commentModel, 'model_id')->hiddenInput(['value' => $model->id]);
        if (Yii::$app->user->isGuest){ ?>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($commentModel, 'name')->textInput([
                    'size' => 30,
                    'aria-required' => true
                ]); ?>
            </div>
        </div>
        <?php
        } else {
            echo $form->field($commentModel, 'user_id')->hiddenInput(['value' => Yii::$app->user->id]);
        }
        ?>
        <span class="reply-span hide"><?= Yii::t('app', 'Reply to') ?></span>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($commentModel, 'content')->textArea([
                    'cols' => 45,
                    'rows' => 8,
                    'aria-required' => true
                ])->label(Yii::t('app', 'Add Your Comment')); ?>
                <input name="submit" type="submit" id="submit" value="<?= Yii::t('app', 'Submit Comment') ?>">
            </div>
        </div>
        <?php \yii\widgets\ActiveForm::end(); ?>
    </div>
    <!-- End Respond Form -->

</div>
<!-- End Comment Area -->
