<?php

namespace api\modules\efenbi\rasasayang\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\efenbi\rasasayang\models\Item;

/**
 * ItemSearch represents the model behind the search form about `lukisongroup\efenbi\models\Item`.
 */
class ItemSearch extends Item
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['STATUS'], 'integer'],
            [['ITEM_ID','CREATE_BY', 'CREATE_AT', 'UPDATE_BY', 'UPDATE_AT','ITEM_NM','IMG64'], 'safe'],
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
        $query = Item::find();

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
            // 'ITEM_ID' => $this->ITEM_ID,
            // 'CREATE_AT' => $this->CREATE_AT,
            // 'UPDATE_AT' => $this->UPDATE_AT,
            'STATUS' => $this->STATUS
        ]);

        $query->andFilterWhere(['like', 'ITEM_ID', $this->ITEM_ID])
			->andFilterWhere(['like', 'CREATE_AT', $this->CREATE_AT])
			->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY])
            ->andFilterWhere(['like', 'UPDATE_AT', $this->UPDATE_AT])
            ->andFilterWhere(['like', 'ITEM_NM', $this->ITEM_NM]);

        return $dataProvider;
    }
}
