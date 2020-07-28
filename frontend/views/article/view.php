<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/** @var $model \backend\models\article\Article*/
/** @var $comment \backend\models\comment\Comment */

?>

<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?=$model->title?></div>
    <div class="panel-body">
        <p><?=$model->description?></p>
    </div>
</div>
<hr>
    <h2><?=Yii::t('app', 'Comment')?></h2>
<hr>
<?php $form = ActiveForm::begin(['action' => ['/comment/create', 'articleId' => $model->id]]);?>

    <?= $form->field($comment, 'description')->textarea()?>

    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary'])?>
<?php ActiveForm::end();?>
    <hr>
<?php foreach ($model->comments as $comment): ?>
    <div class="media">
        <div class="media-body">
            <h4 class="media-heading"><?=$comment->owner->username ?? Yii::t('app', 'anonym')?></h4>
            <?=$comment->description?>
        </div>
    </div>
    <hr>
<?php endforeach;?>