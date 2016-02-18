<?php

namespace api\modules\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\master\models\Kabupaten;

/**
 * KabupatenSearch represents the model behind the search form about `api\modules\master\models\Kabupaten`.
 */
class KabupatenSearch extends Kabupaten
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CITY_ID', 'POSTAL_CODE'], 'integer'],
            [['PROVINCE_ID', 'PROVINCE', 'TYPE', 'CITY_NAME'], 'safe'],
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
        $query = Kabupaten::find();

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
            'CITY_ID' => $this->CITY_ID,
            'POSTAL_CODE' => $this->POSTAL_CODE,
        ]);

        $query->andFilterWhere(['like', 'PROVINCE_ID', $this->PROVINCE_ID])
            ->andFilterWhere(['like', 'PROVINCE', $this->PROVINCE])
            ->andFilterWhere(['like', 'TYPE', $this->TYPE])
            ->andFilterWhere(['like', 'CITY_NAME', $this->CITY_NAME]);

        return $dataProvider;
    }
}
