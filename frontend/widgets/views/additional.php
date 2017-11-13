<?use yii\helpers\Html;?>
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