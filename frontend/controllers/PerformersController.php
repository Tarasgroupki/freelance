<?php

namespace frontend\controllers;

use Yii;
use app\models\Orders;
use app\models\OrderUser;
use app\models\OrdersSearch;
use frontend\models\Category;
use yii\web\Controller;
use pjhl\multilanguage\LangHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;
use common\models\SearchLocation;

/**
 * PerformersController implements the CRUD actions for Orders model.
 */
class PerformersController extends Controller
{
	
	public function actionIndex()
	{
		$user = new User;
		$performers = $user->getPerformers();
		return $this->render('index',
		[
		  'performers' => $performers
		]);
	}
}