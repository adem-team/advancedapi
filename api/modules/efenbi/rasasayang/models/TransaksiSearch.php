<?php

namespace api\modules\efenbi\rasasayang\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\efenbi\rasasayang\models\Transaksi;

/**
 * TransaksiSearch represents the model behind the search form about `api\modules\efenbi\rasasayang\models\Transaksi`.
 */
class TransaksiSearch extends Transaksi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'STATUS', 'TRANS_TYPE', 'ITEM_QTY'], 'integer'],
            [['CREATE_BY', 'CREATE_AT', 'UPDATE_BY', 'UPDATE_AT', 'TRANS_ID', 'TRANS_DATE', 'USER_ID', 'OUTLET_ID', 'OUTLET_NM', 'CONSUMER_NM', 'CONSUMER_EMAIL', 'CONSUMER_PHONE', 'ITEM_ID', 'ITEM_NM', 'ITEM_DISCOUNT_TIME'], 'safe'],
            [['ITEM_HARGA', 'ITEM_DISCOUNT'], 'number'],
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
        $query = Transaksi::find();

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
            'ID' => $this->ID,
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
            'STATUS' => $this->STATUS,
            'TRANS_TYPE' => $this->TRANS_TYPE,
            'TRANS_DATE' => $this->TRANS_DATE,
            'ITEM_QTY' => $this->ITEM_QTY,
            'ITEM_HARGA' => $this->ITEM_HARGA,
            'ITEM_DISCOUNT' => $this->ITEM_DISCOUNT,
        ]);

        $query->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY])
            ->andFilterWhere(['like', 'TRANS_ID', $this->TRANS_ID])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'OUTLET_ID', $this->OUTLET_ID])
            ->andFilterWhere(['like', 'OUTLET_NM', $this->OUTLET_NM])
            ->andFilterWhere(['like', 'CONSUMER_NM', $this->CONSUMER_NM])
            ->andFilterWhere(['like', 'CONSUMER_EMAIL', $this->CONSUMER_EMAIL])
            ->andFilterWhere(['like', 'CONSUMER_PHONE', $this->CONSUMER_PHONE])
            ->andFilterWhere(['like', 'ITEM_ID', $this->ITEM_ID])
            ->andFilterWhere(['like', 'ITEM_NM', $this->ITEM_NM])
            ->andFilterWhere(['like', 'ITEM_DISCOUNT_TIME', $this->ITEM_DISCOUNT_TIME]);

        return $dataProvider;
    }
}
