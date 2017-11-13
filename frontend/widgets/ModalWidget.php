<?php

namespace frontend\widgets;

use yii\base\Widget;
use frontend\models\Profile;
use Yii;
use common\models\User;
use common\models\LoginForm;
use yii\web\Controller;

class ModalWidget extends Widget{
	public function init(){
		parent::init();
	}
	public function run(){
		 if (Yii::$app->user->isGuest) {
            $model = new LoginForm();
            return $this->render('modal', [
                'model' => $model,
            ]);
        } else {
            return ;
        }
	}
}

?>