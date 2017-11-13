<?php

namespace backend\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "orders".
 *
 * @property integer $order_id
 * @property integer $user_id
 * @property string $from
 * @property string $order_title
 * @property string $order_desc
 * @property string $order_slug
 *
 * @property User $user
 */
class Orders extends \yii\db\ActiveRecord
{
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
            [['user_id'], 'integer'],
            [['order_title', 'order_desc', 'order_slug'], 'required'],
            [['order_desc'], 'string'],
            [['from', 'order_title', 'order_slug'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'from' => 'From',
            'order_title' => 'Order Title',
            'order_desc' => 'Order Desc',
            'order_slug' => 'Order Slug',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
