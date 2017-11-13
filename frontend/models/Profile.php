<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "profile".
 *
 * @property integer $user_id
 * @property string $avatar
 * @property string $first_name
 * @property string $second_name
 * @property string $middle_name
 * @property integer $birthday
 * @property integer $gender
 *
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
	public $file;
	public $avatar_main;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
     public function rules()
    {
        return [
		    [['birthday'],'safe'],
            [['gender'], 'integer'],
			[['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
            [['avatar_main'], 'string', 'max' => 255],
            [['first_name', 'second_name'], 'string', 'max' => 32],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'avatar' => 'Avatar',
            'first_name' => 'First Name',
            'second_name' => 'Second Name',
            'middle_name' => 'Middle Name',
            'birthday' => 'Birthday',
            'gender' => 'Gender',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
	public function updateProfile()
	{
		if($this->file == NULL)
		{
			$avatars = $this->selectAvatar();
			$this->avatar_main = $avatars['avatar'];
		}
		$profile = ($profile = Profile::findOne(Yii::$app->user->id)) ? $profile :new Profile();
		$profile->user_id = Yii::$app->user->id;
		$profile->avatar = $this->avatar_main;
		$profile->first_name = $this->first_name;
		$profile->second_name = $this->second_name;
		$profile->birthday = $this->birthday;
		$profile->gender = $this->gender;
		return $profile->save() ? true : false;
	}
	public function selectAvatar(){
		return static::findOne(Yii::$app->user->id);
	}
	public function getAvatar($id)
	{
		return static::findOne($id);
	}
	public function githubProfile($uid,$avatar)
	{
		$Profile = static::findOne($uid);
		if($Profile):
		  return $Profile;
		  else:
		$this->user_id = $uid;
        $this->avatar = $avatar;
        return $this->save() ? $this : null;
		endif;
	}
}
