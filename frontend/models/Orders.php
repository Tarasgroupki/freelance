<?php

namespace app\models;

use Yii;
use dosamigos\transliterator\TransliteratorHelper;

/**
 * This is the model class for table "orders".
 *
 * @property integer $order_id
 * @property integer $user_id
 * @property integer $message_id
 * @property string $order_title
 * @property string $order_desc
 *
 * @property User $user
 */
class Orders extends \yii\db\ActiveRecord
{
	public $message_id;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'message_id','category_id'], 'integer'],
            [['order_title', 'order_desc'], 'required'],
            [['order_desc','price'], 'string'],
            [['order_title'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'user_id' => 'User ID',
            'message_id' => 'Message ID',
            'order_title' => 'Order Title',
            'order_desc' => 'Order Desc',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
	 public function getOrders($id = null)
	 {
		 if($id == null){
		     return static::find()->all();
		 }
		 else
		 {
			 return static::find()->where(['category_id' => $id])->all();
		 }
	 }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
	public function transliterate($slug)
	{
		return str_replace(' ','-',TransliteratorHelper::process($slug, '-', 'en'));	
	}
}
