<?php

namespace api\modules\efenbi\rasasayang\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\efenbi\rasasayang\models\TransaksiType;

/**
 * TransaksiTypeSearch represents the model behind the search form about `api\modules\efenbi\rasasayang\models\TransaksiType`.
 */
class TransaksiTypeSearch extends TransaksiType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'STATUS'], 'integer'],
            [['CREATE_BY', 'CREATE_AT', 'UPDATE_BY', 'UPDATE_AT', 'CODE_TRANS', 'TYPE_NM','TYPE_DCRIP'], 'safe'],
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
        $query = TransaksiType::find();

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
        ]);

        $query->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY])
            ->andFilterWhere(['like', 'CODE_TRANS', $this->CODE_TRANS])
            ->andFilterWhere(['like', 'TYPE_NM', $this->TYPE_NM]);

        return $dataProvider;
    }
}
