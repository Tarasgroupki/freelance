<?php

namespace frontend\controllers;

use Yii;
use app\models\Orders;
use app\models\OrderUser;
use app\models\OrdersSearch;
use frontend\models\Profile;
use frontend\models\Category;
use frontend\models\OrderItem;
use yii\web\Controller;
use pjhl\multilanguage\LangHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;
use common\models\SearchLocation;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
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
                    'actions' => ['index','create','delete','update','view','responce'],
                    'roles' => ['customer'],
                ],
				[
				    'allow' => true,
                    'actions' => ['index','connect','out','view','responce'],
                    'roles' => ['performer'],
				],
            ],
        ],
        ];
    }

    /**
     * Lists all Orders models.
     * @return mixed
     */
    public function actionIndex($cat_id = null)
    {
		$model = new SearchLocation();
		$arr = Yii::$app->request->post();
		$search = $arr['SearchLocation']['address'];
		$latitude = $arr['SearchLocation']['latitude'];
		$longitude = $arr['SearchLocation']['longitude'];
		$category = new Category();
		$categories = $category->getCategories($id=null,LangHelper::getLanguage('id'));
		if($search){
			$orders = Orders::find()->where(['latitude'=>"$latitude"])->andwhere(['longitude'=>"$longitude"])->all();
	    }
		else 
		{
		
		if ($cat_id !== null && isset($categories[$cat_id])) {
			$category = $categories[$cat_id];
		}
		$orders = (new Orders)->getOrders($cat_id);
        }
		$menuItems = $this->getMenuItems($categories, isset($category->id) ? $category->id : null);
		/*$searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
*/
        return $this->render('index', [
		'orders' => $orders,
		'menuItems' => $menuItems,
		'model' => $model
           // 'searchModel' => $searchModel,
           // 'dataProvider' => $dataProvider,
        ]);
    }
	public function actionConnect($id,$user_id)
	{
		$model = new OrderUser;
		$model->connectUser($id,$user_id);
		return $this->render('/messages/index',['id' => $id]);
	}
	
	public function actionOut($id)
	{
		return Yii::$app->db->createCommand()
			->update('orders', ['from' => Yii::$app->user->id], 'order_id ='.(int)$id.'')
			->execute();
	}

    /**
     * Displays a single Orders model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		$type_id = 1;
        return $this->render('view', [
            'model' => $this->findModel($id),
			'type_id' => $type_id,
			'id' => $id
        ]);
    }

    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$categories = Category::find()->all();
        $model = new Orders();
		$model1 = new SearchLocation();
        $arr = Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post()) && $model1->load(Yii::$app->request->post() ) ){
			$model->location = $arr['SearchLocation']['address'];
			$model->latitude = $arr['SearchLocation']['latitude'];
			$model->longitude = $arr['SearchLocation']['longitude'];
			$model->order_slug = $model->transliterate($model->order_title);
            if($model->save()){
			//echo $model->order_slug;die;
			return $this->redirect(['view', 'id' => $model->order_id]);
			}} else {
            return $this->render('create', [
                'model' => $model,
				'model1' => $model1,
				'categories' => $categories
            ]);
        }
    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->order_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Orders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

	public function actionResponce($id)
	{
		$likes = User::find()->where(['id'=>$id])->all()[0];
		$avatar = (new Profile)->getAvatar($id);
		$items = (new OrderItem)->find()->where(['user_id' => $id])->all();
		if(Yii::$app->user->can('customer')):
		$type_id = 2;
		elseif(Yii::$app->user->can('performer')):
		$type_id = 3;
		endif;
		return $this->render('responce',['type_id' => $type_id,'id' => $id,'likes' => $likes,'avatar' => $avatar,'items' => $items]);
	}
    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
	 private function getMenuItems($categories, $activeId = null, $parent = null)
    {
        $menuItems = [];
		//print_r($categories);die;
        foreach ($categories as $category) {
			//print_r($category);
            if ($category->parent_id === $parent) {
                $menuItems[$category->category_id] = [
                    'active' => $activeId === $category->category_id,
                    'label' => $category->cat_name,
                    'url' => ['orders/index', 'cat_id' => $category->category_id,'slug' => $category->slug],
                    'items' => $this->getMenuItems($categories, $activeId, $category->category_id),
                ];
            }
        }//print_r($menuItems);die;
        return $menuItems;
    }
    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
