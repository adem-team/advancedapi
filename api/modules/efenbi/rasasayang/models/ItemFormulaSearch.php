<?php

namespace api\modules\efenbi\rasasayang\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\efenbi\rasasayang\models\ItemFormula;

/**
 * ItemFormulaSearch represents the model behind the search form about `api\modules\efenbi\rasasayang\models\ItemFormula`.
 */
class ItemFormulaSearch extends ItemFormula
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_DTL_FORMULA', 'STATUS', 'TYPE', 'ID_STORE', 'ID_ITEM', 'DISCOUNT_HARI'], 'integer'],
            [['CREATE_BY', 'CREATE_AT', 'UPDATE_BY', 'UPDATE_AT', 'TYPE_NM', 'DISCOUNT_WAKTU'], 'safe'],
            [['DISCOUNT_PESEN'], 'number'],
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
        $query = ItemFormula::find();

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
            'ID_DTL_FORMULA' => $this->ID_DTL_FORMULA,
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
            'STATUS' => $this->STATUS,
            'TYPE' => $this->TYPE,
            'ID_STORE' => $this->ID_STORE,
            'ID_ITEM' => $this->ID_ITEM,
            'DISCOUNT_PESEN' => $this->DISCOUNT_PESEN,
            'DISCOUNT_WAKTU' => $this->DISCOUNT_WAKTU,
            'DISCOUNT_HARI' => $this->DISCOUNT_HARI,
        ]);

        $query->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY])
            ->andFilterWhere(['like', 'TYPE_NM', $this->TYPE_NM]);

        return $dataProvider;
    }
}
