<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use rmrevin\yii\module\Comments;
use frontend\widgets\AdditionalWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Orders */

$this->title = $model->order_title;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?/*= Html::a('Update', ['update', 'id' => $model->order_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->order_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */?>
    </p>
<?=$model['order_title'].'<br />';?>
<?=$model['order_desc'];?>
<?='<h4>Budget:'.$model['price'].'</h4>'?>
    <?/*= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'order_id',
            'user_id',
            'message_id',
            'order_title',
            'order_desc:ntext',
        ],
    ]) */
	echo Comments\widgets\CommentListWidget::widget([
    'entity' => (string) 'photo-15', // type and id
	'item_id' => (int)$model['order_id'],
	'type_id' => (int)$type_id
]);?>
<?='<h1>Схожі замовлення</h1>';?>
<?=AdditionalWidget::widget([
'id' => $id
]);?>
</div>
