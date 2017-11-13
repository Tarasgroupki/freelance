<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Languages;

/**
 * LanguagesSearch represents the model behind the search form about `backend\models\Languages`.
 */
class LanguagesSearch extends Languages
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lang_id'], 'integer'],
            [['lang_name', 'lang_symbols', 'keywords_lang', 'description_lang'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Languages::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'lang_id' => $this->lang_id,
        ]);

        $query->andFilterWhere(['like', 'lang_name', $this->lang_name])
            ->andFilterWhere(['like', 'lang_symbols', $this->lang_symbols])
            ->andFilterWhere(['like', 'keywords_lang', $this->keywords_lang])
            ->andFilterWhere(['like', 'description_lang', $this->description_lang]);

        return $dataProvider;
    }
}
