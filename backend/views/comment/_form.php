<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use common\components\Status;

/* @var $this yii\web\View */
/* @var $model backend\models\comment\Comment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'description')->textarea()?>

    <?= $form->field($model, 'visible')->dropDownList(Status::getStatuses()) ?>

    <?= $form->field($model, 'active')->dropDownList(Status::getStatuses()) ?>

    <?= $form->field($model, 'created_at')->textInput(['disabled' => true]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['disabled' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
