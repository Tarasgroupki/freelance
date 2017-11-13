<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_user".
 *
 * @property integer $order_id
 * @property integer $user_id
 */
class OrderUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id'], 'integer'],
			[['order_id', 'user_id'], 'unique', 'targetAttribute' => ['order_id', 'user_id']]
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
        ];
    }
	public function connectUser($id,$user_id)
	{
		if(Yii::$app->user->id != $user_id):
		$this->order_id = $id;
        $this->user_id = Yii::$app->user->id;
        return $this->save() ? $this : null;
		else:
		return null;
		endif;
		
	}
}
