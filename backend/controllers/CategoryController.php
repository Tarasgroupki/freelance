<?php

namespace backend\controllers;

use Yii;
use app\models\Category;
use backend\models\Languages;
use app\models\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
        ];
    }

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id = null)
    {
        $model = new Category();
		$categories = Category::find()->all();
        $connection = Yii::$app->db;
        $lang = Languages::find()->IndexBy('lang_id')->all();
		for($i = 0;$i<=count($lang);$i++):
		$langs[$i]['lang_id'] = $lang[$i]['lang_id'];
		$langs[$i]['name'] = $lang[$i]['lang_name'];
		endfor;
		if ($model->load(Yii::$app->request->post())) {
			$max = $connection->createCommand('SELECT MAX(category_id) FROM `category`')->queryOne();
            $max = $max['MAX(category_id)'] + 1;
			if($model->validate()){
            $model->category_id = $max;
			$model->InsertORUpdate($max,$model->lang_id);
			return $this->redirect(['view', 'id' => $model->category_id]);
        } }else {
            return $this->render('create', [
			    'categories' => $categories,
			    'langs' => $langs,
                'model' => $model,
            ]);
        }
    }
	
	 public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $lang = Languages::find()->IndexBy('lang_id')->all();
        $categories = Category::find()->all();
		$all_news = Category::find()->where(['category_id'=> $id])->IndexBy('lang_id')->all();
		for($i = 0;$i<=count($lang);$i++):
		$langs[$i]['lang_id'] = $lang[$i]['lang_id'];
		$langs[$i]['name'] = $lang[$i]['lang_name'];
		$langs[$i]['cat_id'] = $all_news[$i]['cat_id'];
		$langs[$i]['cat_name'] = $all_news[$i]['cat_name'];
		$langs[$i]['cat_description'] = $all_news[$i]['cat_desc'];
		endfor;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$model->InsertORUpdate(null,null);
			return $this->redirect(['view', 'id' => $model->category_id]);
        } else {
            return $this->render('update', [
			    'categories' => $categories,
			    'langs' => $langs,
                'model' => $model,
				'id' => $id,
            ]);
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        Yii::$app->db->createCommand()->delete(Category::tableName(),['category_id' => $id],$params = [])
		->execute();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
     protected function findModel($id)
    {
        if (($model = Category::find()->where(['category_id'=>$id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
