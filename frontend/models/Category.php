<?php

namespace frontend\models;

use Yii;
use dosamigos\transliterator\TransliteratorHelper;

/**
 * This is the model class for table "category".
 *
 * @property integer $cat_id
 * @property integer $category_id
 * @property integer $lang_id
 * @property string $cat_name
 * @property string $cat_desc
 * @property string $slug
 */
class Category extends \yii\db\ActiveRecord
{
	public $cat_translate = array();
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
		    [['parent_id'], 'default', 'value' => null],
            [['category_id', 'lang_id','parent_id'], 'integer'],
            [['cat_translate'],'validatorRequiredWords'],
            [['cat_name', 'slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cat_id' => 'Cat ID',
            'category_id' => 'Category ID',
            'lang_id' => 'Lang ID',
            'cat_name' => 'Cat Name',
            'cat_desc' => 'Cat Desc',
            'slug' => 'Slug',
        ];
    }
		public function getCategories($id,$lang)
	{
		$connection = Yii::$app->db;
		if($id != null):
		/*$categories = $connection
		->createCommand('SELECT * FROM `category` WHERE `category_id` ='.$id.' AND `lang_id` ='.$lang.'')
		->queryAll();*/
		$categories = Category::find()->where(['category_id'=>$id])->andwhere(['lang_id'=>$lang])->all();
		else:
		/*$categories = $connection
		->createCommand('SELECT * FROM `category` WHERE `lang_id` ='.$lang.'')
		->queryAll();*/
		$categories = Category::find()->where(['lang_id'=>$lang])->all();
		endif;
		return $categories;
	}
	public function getParent()
    {
        return $this->hasOne(Category::className(), ['cat_id' => 'parent_id']);
    }
}
