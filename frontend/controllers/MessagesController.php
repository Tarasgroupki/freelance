<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class MessagesController extends Controller {

 public function actions()
    {
        return [
            'private-messages' => [
                'class' => \vision\messages\actions\MessageApiAction::className()
            ]
        ];
    }	
	public function actionIndex($id)
	{
		return $this->render('index',compact('id'));
	}
	public function actionDialog()
	{
		return $this->render('index');
	}
	public function actionCreate()
	{
		return $this->render('create');
	}
	
}