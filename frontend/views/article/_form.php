<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\Status;
use dosamigos\ckeditor\CKEditor;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\models\article\ArticleTag;
use backend\models\category\Category;

/* @var $this yii\web\View */
/* @var $model backend\models\article\Article */
/* @var $form yii\widgets\ActiveForm */
/** @var $articleTags array */

?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(CKEditor::class, [
        'preset' => 'standard',
        'clientOptions' => [
            'height' => '150px',
        ]
    ])?>

    <div class="form-group field-article-tags">
        <label class="control-label" for="article-tags">Tags</label>
        <?=
        Select2::widget([
            'name' => 'Article[tags]',
            'value' => ArrayHelper::map($articleTags, 'name', 'id'),
            'data' => ArticleTag::getAll(),
            'options' => [
                'placeholder' => 'Select skill',
                'multiple' => true,
                '',
                'class' => 'form-control',
            ],
            'pluginOptions' => [
                'tags' => true,
                'tokenSeparators' => [',', ' '],
                'maximumInputLength' => 15,
            ],
            'pluginEvents' => [
                "change" => "function (params) {
                        var tagsName = $(this).parents('.tags');
                        var cssValidation = tagsName.find('span.select2-selection.select2-selection--multiple');
                        var button = tagsName.find('button');
                        cssValidation.css('box-shadow', '');
                        cssValidation.css('border-color', '');
                        return button.prop('disabled', false);
                  }",
            ],
        ])
        ?>

        <?= $form->field($model, 'listCategories')->widget(Select2::class, [
            'data' =>  ArrayHelper::map(Category::getListCategory(), 'id', 'name'),
            'options' => [
                'placeholder' => 'Select a user ...',
                'multiple' => true, '',
            ],
            'pluginOptions' => [
                'tokenSeparators' => [',', ' '],
                'maximumInputLength' => 10,
            ],
        ])?>

        <div class="help-block"></div>
    </div>

    <?php if (!$model->isNewRecord):?>

        <?= $form->field($model, 'created_at')->textInput(['disabled' => true]) ?>

        <?= $form->field($model, 'updated_at')->textInput(['disabled' => true]) ?>

    <?php endif;?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
