<?php

namespace api\modules\efenbi\rasasayang\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\efenbi\rasasayang\models\TransaksiClosing;

/**
 * TransaksiClosingSearch represents the model behind the search form about `lukisongroup\efenbi\rasasayang\models\TransaksiClosing`.
 */
class TransaksiClosingSearch extends TransaksiClosing
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['CREATE_AT', 'UPDATE_AT', 'TRANS_DATE','BUY','RCVD','SELL','SISA','IMG64'], 'safe'],
           [['STATUS'], 'integer'],
           [['CREATE_BY', 'UPDATE_BY', 'OUTLET_ID'], 'string', 'max' => 50],
           [['ITEM_BARCODE','OUTLET_ID'], 'string', 'max' => 100]
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
        $query = TransaksiClosing::find();

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
            'TRANS_DATE' => $this->TRANS_DATE,
            'OUTLET_ID' => $this->OUTLET_ID,
            'ITEM_BARCODE' => $this->ITEM_BARCODE,
        ]);

        $query->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY])
            ->andFilterWhere(['like', 'BUY', $this->BUY])
            ->andFilterWhere(['like', 'RCVD', $this->RCVD])
            ->andFilterWhere(['like', 'SELL', $this->SELL])
            ->andFilterWhere(['like', 'SISA', $this->SISA]);

        return $dataProvider;
    }
}
