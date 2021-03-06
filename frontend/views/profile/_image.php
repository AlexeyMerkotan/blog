<?php
use yii\helpers\Html;
use kartik\file\FileInput;

?>


<?= $form->field($model, 'image')->widget(FileInput::classname(), [
    'pluginOptions' => [
        'initialPreview' => [
            !empty($model->image)
                ? '<a href="' . $model->imageUrl . '" title="' . $model->username  . '" data-gallery>'
                . Html::img($model->imageThumbnailUrl, ['class' => 'img-preview', 'title' => $model->username, 'alt' => $model->username])
                . '<br />'
                . '</a>'
                : null
        ],
        'overwriteInitial' => true,
        'pluginLoading' => true,
        'showCaption' => false,
        'showUpload' => false,
        'showClose' => false,
        'removeClass' => 'btn btn-danger',
        'browseClass' => 'btn btn-success',
        'browseLabel' => '',
        'removeLabel' => '',
        'browseIcon' => '<i class="glyphicon glyphicon-picture"></i>',
        'previewTemplates' => [
            'generic' => '<div class="file-preview-frame" id="{previewId}" data-fileindex="{fileindex}">
                    {content}
                </div>',
            'image' => '<div class="file-preview-frame" id="{previewId}" data-fileindex="{fileindex}">
                    <img src="{data}" class="img-preview" title="{caption}" alt="{caption}">
                </div>',
        ]
    ],
]) ?>