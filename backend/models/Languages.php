<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "languages".
 *
 * @property integer $lang_id
 * @property string $lang_name
 * @property string $lang_symbols
 * @property string $keywords_lang
 * @property string $description_lang
 *
 * @property News[] $news
 */
class Languages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'languages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lang_name', 'lang_symbols', 'keywords_lang'], 'required'],
            [['description_lang'], 'string'],
            [['lang_name', 'lang_symbols', 'keywords_lang'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lang_id' => 'Lang ID',
            'lang_name' => 'Lang Name',
            'lang_symbols' => 'Lang Symbols',
            'keywords_lang' => 'Keywords Lang',
            'description_lang' => 'Description Lang',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::className(), ['lang_id' => 'lang_id']);
    }
}
