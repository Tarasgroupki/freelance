<?php

namespace frontend\widgets;

use yii\base\Widget;
use frontend\models\Profile;
use Yii;
use common\models\User;

class ProfileWidget extends Widget{
	public function init(){
		parent::init();
	}
	public function run(){
		//$langs = Yii::$app->cache->get('langs');
		//if($langs){$langs = Yii::$app->cache->get('langs');}
		//else{$langs = Languages::find()->select('')->all();}
        $profile = Profile::find()->where(['user_id' => Yii::$app->user->id])->one();
	    //Yii::$app->cache->set('langs',$langs,60);	
		return $this->render('profile',compact('profile'));
	}
}

?>