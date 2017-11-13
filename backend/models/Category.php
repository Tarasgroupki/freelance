<?php

namespace app\models;

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
	public function validatorRequiredWords()
{ 
    foreach ( $this->cat_translate as $cat ) {
        if(empty($cat['cat_name']) && empty($cat['cat_description'])) {
			$this->addError('cat_translate', 'Не заповнені всі поля!');     
        }
    }
}
	public function InsertORUpdate($max=null,$lang_id)
	{
		$connection = Yii::$app->db;
		if(!is_null($max))
		{
			 foreach($this->cat_translate as $key => $name){
				 $name['parent_id'] = $this->parent_id;
				 $name['category_id'] = $max;	 
				 $name['slug'] = $this->transliterate($name['cat_name']);
				 $names[] = $name; 
			 }//print_r($names);die;
			$connection->createCommand()->batchInsert(Category::tableName(),['cat_id','lang_id','cat_name','cat_desc','parent_id','category_id','slug']
			,$names)->execute();
		}
		else
		{
		foreach($this->cat_translate as $key => $name){
				 $name['parent_id'] = $this->parent_id;
				 $name['slug'] = $this->transliterate($name['cat_name']);
				 $names[] = $name;
			 }
		$query = $connection->queryBuilder->batchInsert(Category::tableName(),['cat_id','lang_id','cat_name','cat_desc','parent_id','slug']
		,$names);
		$connection->createCommand($query . " ON DUPLICATE KEY UPDATE `lang_id` = VALUES(`lang_id`), `cat_name` = VALUES(`cat_name`), `cat_desc`= VALUES(`cat_desc`),`parent_id` = VALUES(`parent_id`), `slug`= VALUES(`slug`)")->execute();
		}
	}
	/**/
	public function Max_news()
	{
		$connection = Yii::$app->db;
		$file_id = $connection->createCommand('SELECT MAX(newsapp_id) FROM `news` GROUP BY `lang_id`')->queryAll();	
	    return $file_id;
	}
	public function getParent()
    {
        return $this->hasOne(Category::className(), ['cat_id' => 'parent_id']);
    }
	public function transliterate($slug)
	{
		return str_replace(' ','-',TransliteratorHelper::process($slug, '-', 'en'));	
	}
}
