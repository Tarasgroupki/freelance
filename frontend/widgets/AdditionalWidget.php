<?php

namespace frontend\widgets;

use yii\base\Widget;
use app\models\Orders;
use Yii;

class AdditionalWidget extends Widget{
	public $id;
	public function init(){
		parent::init();
	}
	public function run(){
		$orders = Orders::find()->where(['!=','order_id',$this->id])->limit(5)->all();
		return $this->render('additional',compact('orders'));
	}
}