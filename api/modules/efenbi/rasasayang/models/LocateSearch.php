<?php

namespace api\modules\efenbi\rasasayang\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\efenbi\rasasayang\models\Locate;

/**
 * LocateSearch represents the model behind the search form about `api\modules\efenbi\rasasayang\models\Locate`.
 */
class LocateSearch extends Locate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CREATE_BY', 'CREATE_AT', 'UPDATE_BY', 'UPDATE_AT', 'PARENT', 'LOCATE', 'LOCATE_NAME'], 'safe'],
            [['STATUS', 'ID'], 'integer'],
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
        $query = Locate::find();

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
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
            'STATUS' => $this->STATUS,
            'ID' => $this->ID,
        ]);

        $query->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY])
            ->andFilterWhere(['like', 'PARENT', $this->PARENT])
            ->andFilterWhere(['like', 'LOCATE', $this->LOCATE])
            ->andFilterWhere(['like', 'LOCATE_NAME', $this->LOCATE_NAME]);

        return $dataProvider;
    }
}
