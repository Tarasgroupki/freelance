<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Languages */

$this->title = 'Update Languages: ' . $model->lang_id;
$this->params['breadcrumbs'][] = ['label' => 'Languages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->lang_id, 'url' => ['view', 'id' => $model->lang_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="languages-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
