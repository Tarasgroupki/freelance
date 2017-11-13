<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			'cat_id',
            [
                'attribute' => 'parent_id',
                'value' => function ($model) {
                    return empty($model->parent_id) ? '-' : $model->parent->cat_name;
                },
            ],
            'category_id',
            'lang_id',
            'cat_name',
            'cat_desc:ntext',
            // 'slug',

            ['class' => 'yii\grid\ActionColumn',
			'urlCreator'=>function($action, $model, $key, $index){
                   return [$action,'id'=>$model->category_id];
               },
           'template'=>'{view} {update} {delete}'],
        ],
    ]); ?>
</div>
