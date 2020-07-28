<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Role;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList(\common\models\User::getStatuses()) ?>

    <?= $form->field($model, 'email')->textInput() ?>

    <?= $form->field($model, 'role')->dropDownList(Role::getRoles()) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
