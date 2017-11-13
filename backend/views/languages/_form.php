<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Languages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="languages-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lang_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lang_symbols')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keywords_lang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description_lang')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
