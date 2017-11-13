<?php

namespace frontend\controllers;

use Yii;
use frontend\models\OrderItem;
use app\models\ItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * ItemsController implements the CRUD actions for OrderItem model.
 */
class ItemsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
			'access' => [
            'class' => AccessControl::className(),
           // 'only' => ['',''],
			'rules' => [
                [
                    'allow' => true,
                    //'actions' => [''],
                    'roles' => ['performer'],
                ],
            ],
        ],
        ];
    }

    /**
     * Lists all OrderItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OrderItem model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new OrderItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OrderItem();

        if ($model->load(Yii::$app->request->post()) ) {
			/*Gallery making*/
		    $gallery_name = 'Gallery'.Yii::$app->user->id.'';
			$alias = Yii::getAlias('@frontend/web/images/projects/' .  $gallery_name);
                    try {
                        //если создавать рекурсивно, то работает через раз хз почему.
                        $old = umask(0);
                        mkdir($alias, 0777, true);
                        chmod($alias, 0777);
                       // mkdir($alias . '/thumb', 0777);
                       // chmod($alias . '/thumb', 0777);
                        umask($old);
                    } catch (\Exception $e){
                        return('Не удалось создать директорию ' . $alias . ' - ' . $e->getMessage());
                    }
			/*End of Gallery making*/
			$model->file = UploadedFile::getInstance($model, 'file'); 
			if($model->validate()){
			$model->img_url = '/images/projects/'.$gallery_name.'/' . $model->file->baseName . '.' . $model->file->extension;
			Yii::setAlias('upload', dirname(dirname(__DIR__)) . '/frontend/web/images/projects/'.$gallery_name.'/');
			$model->file->saveAs(Yii::getAlias('@upload').'/'. $model->file->baseName . '.' . $model->file->extension);
			if($model->save()){
			return $this->redirect(['view', 'id' => $model->delivery_id]);
			}} }else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing OrderItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
			$model->file = UploadedFile::getInstance($model, 'file');
			if($model->validate()){
            $gallery_name = 'Gallery'.Yii::$app->user->id.'';
			$model->img_url = '/images/projects/'.$gallery_name.'/' . $model->file->baseName . '.' . $model->file->extension;
		    Yii::setAlias('upload', dirname(dirname(__DIR__)) . '/frontend/web/images/projects/'.$gallery_name.'/');
			$model->file->saveAs(Yii::getAlias('@upload').'/'. $model->file->baseName . '.' . $model->file->extension);
		   if($model->save()){
		   return $this->redirect(['view', 'id' => $model->delivery_id]);
		   }    } }else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing OrderItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the OrderItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrderItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrderItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
