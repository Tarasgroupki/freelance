<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order_item".
 *
 * @property integer $delivery_id
 * @property integer $user_id
 * @property string $img_url
 * @property string $link
 *
 * @property User $user
 */
class OrderItem extends \yii\db\ActiveRecord
{
	public $file;
	//public $file_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['img_url', 'link'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'delivery_id' => 'Delivery ID',
            'user_id' => 'User ID',
            'img_url' => 'Img Url',
            'link' => 'Link',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
	public function InsertOrUpdate()
	{
		echo '<pre>'.print_r($this).'</pre>';
	}
}
