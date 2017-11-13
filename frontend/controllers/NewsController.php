<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use frontend\models\News;
use frontend\models\Newsapps;
use frontend\models\Profile;
use frontend\models\Category;
use pjhl\multilanguage\LangHelper;
use yii\filters\AccessControl;
use common\models\SearchLocation;
use mitrm\likes\Likes;
use chiliec\vote\models\Rating;

class NewsController extends Controller {
	public function behaviors()
{
    return [
        /*'access' => [
            'class' => AccessControl::className(),
           // 'only' => ['',''],
			'rules' => [
                [
                    'allow' => true,
                    'actions' => ['list','view'],
                    'roles' => ['viewAdminPage'],
                ],
				[
				    'allow' => true,
				    'actions' => ['profile'],
				    'roles' => ['author']
				],
            ],
        ],*/
		/*[
		  'class' => 'yii\filters\HttpCache',
		  'only' => ['list'],
		  'lastModified' => function () {
			    return News::find()->max('updated_at');
		        
		   },
		   'etagSeed' => function (){
			   return $this->getIdentityUser();
		   },
		   
		]*/
    ];
}
public function getIdentityUser()
{
    return Yii::$app->user->identity['username'] ?  : Yii::$app->user->identity['username'];
}
	public function actionProfile()
    {
        $model = ($model = Profile::findOne(Yii::$app->user->id)) ? $model : new Profile();
		if($model->load(Yii::$app->request->post())){		
       $model->file = UploadedFile::getInstance($model, 'file');	       
	   if($model->validate()):
            $model->avatar_main = '/images/avatars/' . $model->file->baseName . '.' . $model->file->extension;			
		  if($model->file->baseName != NULL){
		  $model->file->saveAs('images/avatars/' . $model->file->baseName . '.' . $model->file->extension);
		  }
			if($model->updateProfile()):
                Yii::$app->session->setFlash('success', 'Профиль изменен');
            else:
                Yii::$app->session->setFlash('error', 'Профиль не изменен');
                Yii::error('Ошибка записи. Профиль не изменен');
                return $this->refresh();
            endif;
        endif;
		}
        return $this->render(
            'profile',
            [
                'model' => $model,
				'model_file' => $model_file
            ]
        );
    }
}