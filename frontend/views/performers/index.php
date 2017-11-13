<?php

use yii\helpers\Html;
use yii\widgets\Menu;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Performers';
$this->params['breadcrumbs'][] = $this->title;
echo '<h1>'.$this->title.'</h1>';
?>
<?foreach($performers as $key => $performer){?>
  <?=Html::a($performer['username'], ['orders/responce/'.$performer['id']]) ?>
  <br />
  <?=$performer['email'];?>
  <br />
  <?}?>