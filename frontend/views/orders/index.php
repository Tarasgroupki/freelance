<?php

use yii\helpers\Html;
use yii\widgets\Menu;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<?$form = \yii\widgets\ActiveForm::begin();
echo $form->field($model, 'address')->widget(\kalyabin\maplocation\SelectMapLocationWidget::className(), [
    'attributeLatitude' => 'latitude',
    'attributeLongitude' => 'longitude',
    'googleMapApiKey' => 'AIzaSyD51DSa_eCa5MkwKNPZEuYjgFvuGzwqg1c',
]);?>
 <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11 search">
            <?= Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?
\yii\widgets\ActiveForm::end();
?>
<div class="col-xs-4">
          <?= Menu::widget([
              'items' => $menuItems,
              'options' => [
                  'class' => 'menu',
              ],
          ]) ?>
      </div>
	  <br />
<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?if(Yii::$app->user->can('customer')):?>
    <p>
        <?= Html::a('Create Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	<?endif;?>
	<?foreach($orders as $key => $order):?>
	<?=Html::a($order['order_title'], ['orders/view/'.$order['order_id'].'/'.$order['order_slug'].'/'])?>
	<?=$order['order_desc']?>
	<?if(Yii::$app->user->can('performer')):?>
	<?//=Html::a('Connect to order', ['orders/connect/'.$order['order_id'].'/'.$order['user_id'].'/'], ['class' => 'btn btn-success'])?>
	<?//=Html::a('Out from order', ['orders/out/'.$order['order_id'].'/'], ['class' => 'btn btn-success'])?>
	<?endif;?>
	<?='<h4>Budget:'.$order['price'].'</h4>'?>
	<?='<br />'?>
	<?endforeach;?>
    <?/*= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'order_id',
            'user_id',
            'message_id',
            'order_title',
            'order_desc:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); */?>
</div>
