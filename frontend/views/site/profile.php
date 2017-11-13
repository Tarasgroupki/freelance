<?php
use yii\jui\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Profile */
/* @var $form ActiveForm */
$this->title = 'Акаунт';
?>
<div class="news-profile">
<?php 
$avatar = $model->selectAvatar();
?>
<img style="height:600px; width:800px;" src="<?=$avatar['avatar']?>" />
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <?= $form->field($model, 'file')->fileInput() ?>
        <?= $form->field($model, 'first_name') ?>
        <?= $form->field($model, 'second_name') ?>
        <?= $form->field($model, 'birthday')->widget(\yii\jui\DatePicker::classname(), [
    'language' => 'ru-Ru',
    'dateFormat' => 'yyyy-MM-dd',
]) ?>
        <?= $form->field($model, 'gender')->radioList([
              '1' => 'Male',
              '2' => 'Female',
            ]);?>
		<div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
<?= Html::a('Dialogs', ['messages/dialog/'], ['class' => 'profile-link']).'<br />' ?>
<?if(Yii::$app->user->can('findPerformer')):?>
<?= Html::a('Orders', ['site/order'], ['class' => 'profile-link']).'<br />' ?>
<?elseif(Yii::$app->user->can('findCustomer')):?>
<?= Html::a('Orders', ['site/orders'], ['class' => 'profile-link']).'<br />' ?>
<?endif;?>
<?= Html::a('Responce', ['orders/responce/'.Yii::$app->user->id .''], ['class' => 'profile-link']).'<br />' ?>
<?if(Yii::$app->user->can('findCustomer')):?>
<?= Html::a('Items', ['items/index'], ['class' => 'profile-link']).'<br />' ?>
<?endif;?>
</div><!-- news-profile -->
