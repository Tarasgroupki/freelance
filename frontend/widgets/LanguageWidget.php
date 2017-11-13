<?php

namespace frontend\widgets;

use yii\base\Widget;
use frontend\models\Languages;
use Yii;

class LanguageWidget extends Widget{
	public function init(){
		parent::init();
	}
	public function run(){
		//$langs = Yii::$app->cache->get('langs');
		//if($langs){$langs = Yii::$app->cache->get('langs');}
		//else{$langs = Languages::find()->select('')->all();}
        $langs = Languages::find()->all();
	    //Yii::$app->cache->set('langs',$langs,60);	
		return $this->render('lang',compact('langs'));
	}
}

?>