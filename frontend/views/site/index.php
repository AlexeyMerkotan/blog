<?php

use common\components\ShortText;
use yii\helpers\Html;
use backend\models\article\frontend\Article;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/** @var $articles \backend\models\article\Article[] */

$this->title = 'My Yii Application';
?>
<?= Html::a(Yii::t('app', 'Create article'), ['/article/create'], ['class' => 'btn btn-primary'])?>
<hr>
<?php $form = \yii\bootstrap\ActiveForm::begin() ?>
<div class="form-group">
    <label for="exampleFormControlSelect1"><?= Yii::t('app', 'Type') ?></label>
    <?= Html::dropDownList('type_post', '', Article::getListPost()) ?>
</div>
<button type="submit" class="btn btn-primary"><?=Yii::t('app', 'Search')?></button>
<?php ActiveForm::end(); ?>
<hr>
<div class="site-index">
    <?php foreach ($articles as $article):?>
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <div class="caption">
                        <h3><?=$article->title?></h3>
                        <p><?=ShortText::make($article->description)?></p>
                        <p>
                            <?=Html::a(Yii::t('app', 'Detail'), ['/article/view?id=' . $article->id], ['class' => 'btn btn-primary'])?>

                            <?= $article->isAccess() ? Html::a(Yii::t('app', 'Update'), ['/article/update?id=' . $article->id], ['class' => 'btn btn-default']) : ''?>
                        </p>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <span class="badge"><?=count($article->comments)?></span>
                               <?=Yii::t('app', 'Comments')?>
                            </li>
                            <li class="list-group-item">
                                <span class="badge"><?=count($article->articleStatistics)?></span>
                                <?=Yii::t('app', 'Statistics')?>
                            </li>
                            <li class="list-group-item">
                                <?=Yii::t('app', 'Owner')?>
                                <?=Html::a( $article->owner->username, ['/profile/view/?id=' . $article->owner_id], [])?>
                            </li>
                            <li class="list-group-item">
                                <?=Yii::t('app', 'Create at')?>
                                <?=$article->created?>
                            </li>
                            <li class="list-group-item">
                                <?php foreach ($article->articleTags as $tag):?>
                                    <span class="badge"><?=$tag->name?></span>
                                <?php endforeach;?>
                                <?=Yii::t('app', 'Tags')?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach;?>
</div>
