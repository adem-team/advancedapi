<?php

namespace api\modules\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\master\Unitbarang;

/**
 * UnitbarangSearch represents the model behind the search form about `app\models\master\Unitbarang`.
 */
class UnitbarangSearch extends Unitbarang
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'STATUS'], 'integer'],
            [['KD_UNIT', 'NM_UNIT', 'SIZE', 'COLOR', 'NOTE', 'CREATED_BY', 'CREATED_AT', 'UPDATED_BY', 'UPDATED_AT'], 'safe'],
            [['WIGHT'], 'number'],
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
        $query = Unitbarang::find()->where('STATUS <> 3');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ID' => $this->ID,
            'WIGHT' => $this->WIGHT,
            'CREATED_AT' => $this->CREATED_AT,
            'UPDATED_AT' => $this->UPDATED_AT,
            'STATUS' => $this->STATUS,
        ]);

        $query->andFilterWhere(['like', 'KD_UNIT', $this->KD_UNIT])
            ->andFilterWhere(['like', 'NM_UNIT', $this->NM_UNIT])
            ->andFilterWhere(['like', 'SIZE', $this->SIZE])
            ->andFilterWhere(['like', 'COLOR', $this->COLOR])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
            ->andFilterWhere(['like', 'UPDATED_BY', $this->UPDATED_BY]);

        return $dataProvider;
    }
}
