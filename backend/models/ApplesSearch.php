<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Apples;

/**
 * ApplesSearch represents the model behind the search form of `app\models\Apples`.
 */
class ApplesSearch extends Apples
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_create', 'date_fall' ,'date_up', 'color', 'status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Apples::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->defaultOrder = ['date_create' => SORT_DESC];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'color' => $this->color,
            'status' => $this->status,
            'DATE_FORMAT(date_create, \'%Y-%m-%d %H\')' => $this->date_create,

        ]);

        return $dataProvider;
    }
}

