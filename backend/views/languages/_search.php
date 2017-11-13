<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\LanguagesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="languages-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'lang_id') ?>

    <?= $form->field($model, 'lang_name') ?>

    <?= $form->field($model, 'lang_symbols') ?>

    <?= $form->field($model, 'keywords_lang') ?>

    <?= $form->field($model, 'description_lang') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
