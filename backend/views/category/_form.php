<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">
<div class="tabs_menu">
<?php foreach($langs as $key => $lang):?>
<a class="a_link" href="#tab<?=$lang['lang_id'];?>"><?=$lang['name']?></a>
<?php endforeach;?>
</div>
<?php foreach($langs as $key => $lang):?>
<?php if($lang['lang_id'] == 1){?>
<?//=$lang['lang_id'];?>
<div class="tab" id = "tab<?=$lang['lang_id']?>">
    <?php $form = ActiveForm::begin(); ?>
   <?=$lang['name']?>
   <?= $form->field($model, "cat_translate[".$key."][id]")->hiddenInput(['value' => $lang['cat_id'] ])->label(false) ?>
   <?= $form->field($model, "cat_translate[".$key."][lang_id]")->hiddenInput(['value' => "{$lang['lang_id']}" ])->label(false) ?>
	<?= $form->field($model, "cat_translate[".$key."][cat_name]")->textInput(['value' => $lang['cat_name']]) ?>
    <?= $form->field($model, "cat_translate[".$key."][cat_description]")->textarea(['value' => $lang['cat_description']]) ?>
</div>
<?php }?>
<?php if($lang['lang_id'] > 1) {?>
<?//=$lang['lang_id'];?>
<div class="tab" id = "tab<?=$lang['lang_id']?>" style="display:none;">
<?=$lang['name']?>
<?= $form->field($model, "cat_translate[".$key."][id]")->hiddenInput(['value' => $lang['cat_id'] ])->label(false) ?>
   <?= $form->field($model, "cat_translate[".$key."]['lang_id']")->hiddenInput(['value' => "{$lang['lang_id']}" ])->label(false) ?>
	<?= $form->field($model, "cat_translate[".$key."][cat_name]")->textInput(['value' => $lang['cat_name']]) ?>
    <?= $form->field($model, "cat_translate[".$key."][cat_description]")->textarea(['value' => $lang['cat_description']]) ?>
</div>
<?php }?>
<?php endforeach;?>
<?= $form->field($model, 'parent_id')->dropDownList(ArrayHelper::map($categories, 'category_id', 'cat_name'), ['prompt' => 'Root']) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
