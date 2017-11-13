<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Orders */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orders-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput(['value' => Yii::$app->user->identity['id']]) ?>

    <?= $form->field($model, 'message_id')->textInput() ?>

    <?= $form->field($model, 'order_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_desc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map($categories, 'category_id', 'cat_name'), ['prompt' => 'Select category']) ?>
	
	<?= $form->field($model, 'price')->textInput()?>
	
	<?echo $form->field($model1, 'address')->widget(\kalyabin\maplocation\SelectMapLocationWidget::className(), [
                            'attributeLatitude' => 'latitude',
                            'attributeLongitude' => 'longitude',
                            'googleMapApiKey' => 'AIzaSyBRUKGNo8zHLUyIa0OqlJG3JLRob0HuxIg',
                ]);?>
	<?//= $form->field($model, 'order_slug')->hiddenInput(['value' => $model->transliterate($model->order_title)]);?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
