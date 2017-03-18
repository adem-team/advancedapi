<?php

namespace api\modules\efenbi\rasasayang\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\efenbi\rasasayang\models\ItemFormulaDetail;

/**
 * ItemFormulaSearch represents the model behind the search form about `api\modules\efenbi\rasasayang\models\ItemFormula`.
 */
class ItemFormulaDetailSearch extends ItemFormulaDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CREATE_AT', 'UPDATE_AT', 'DISCOUNT_WAKTU1','DISCOUNT_WAKTU2','DISCOUNT_VALUE'], 'safe'],
            [['STATUS','DISCOUNT_QTY'], 'integer'],
            [['CREATE_BY', 'UPDATE_BY','PARENT_ID','DISCOUNT_HARI'], 'string', 'max' => 50],
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
        $query = ItemFormulaDetail::find();

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
            'PARENT_ID' => $this->PARENT_ID,            
            'STATUS' => $this->STATUS,
            'DISCOUNT_HARI' => $this->DISCOUNT_HARI,
        ]);
       $query->andFilterWhere(['like', 'DISCOUNT_HARI', $this->DISCOUNT_HARI])
            ->andFilterWhere(['like', 'DISCOUNT_QTY', $this->DISCOUNT_QTY])
            ->andFilterWhere(['like', 'DISCOUNT_WAKTU1', $this->DISCOUNT_WAKTU1])
            ->andFilterWhere(['like', 'DISCOUNT_WAKTU2', $this->DISCOUNT_WAKTU2])
            ->andFilterWhere(['like', 'DISCOUNT_VALUE', $this->DISCOUNT_VALUE])
            ->andFilterWhere(['like', 'CREATE_AT', $this->CREATE_AT])
            ->andFilterWhere(['like', 'CREATE_AT', $this->CREATE_AT])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY])
            ->andFilterWhere(['like', 'UPDATE_AT', $this->UPDATE_AT]);

        return $dataProvider;
    }
}
