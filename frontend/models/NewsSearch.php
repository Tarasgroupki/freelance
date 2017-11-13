<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\News;

/**
 * NewsSearch represents the model behind the search form about `backend\models\News`.
 */
class NewsSearch extends News
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['news_id', 'newsapp_id', 'category_id', 'lang_id'], 'integer'],
            [['news_name', 'news_description'], 'safe'],
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
        $query = News::find();

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
            'news_id' => $this->news_id,
            'newsapp_id' => $this->newsapp_id,
            'category_id' => $this->category_id,
            'lang_id' => $this->lang_id,
        ]);

        $query->andFilterWhere(['like', 'news_name', $this->news_name])
            ->andFilterWhere(['like', 'news_description', $this->news_description]);

        return $dataProvider;
    }
}
