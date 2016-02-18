<?php

namespace api\modules\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\master\Kategori;

/**
 * KategoriSearch represents the model behind the search form about `app\models\master\Kategori`.
 */
class KategoriSearch extends Kategori
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'STATUS'], 'integer'],
            [['KD_KATEGORI', 'NM_KATEGORI', 'NOTE', 'CREATED_BY', 'CREATED_AT', 'UPDATED_BY', 'UPDATED_AT'], 'safe'],
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
        $query = Kategori::find()->where('STATUS <> 3');

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
 //           'id' => $this->id,
            'CREATED_AT' => $this->CREATED_AT,
            'UPDATED_AT' => $this->UPDATED_AT,
            'STATUS' => $this->STATUS,
        ]);

        $query->andFilterWhere(['like', 'KD_KATEGORI', $this->KD_KATEGORI])
            ->andFilterWhere(['like', 'NM_KATEGORI', $this->NM_KATEGORI])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE]);
//            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
//            ->andFilterWhere(['like', 'UPDATED_BY', $this->UPDATED_BY]);

        return $dataProvider;
    }
}
