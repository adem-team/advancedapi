<?php

namespace lukisongroup\models\system\erpmodul;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\models\system\erpmodul\Modulerp;

/**
 * ModulerpSearch represents the model behind the search form about `lukisongroup\models\system\erpmodul\Modulerp`.
 */
class ModulerpSearch extends Modulerp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MODUL_ID', 'MODUL_STS', 'SORT'], 'integer'],
            [['MODUL_NM', 'MODUL_DCRP'], 'safe'],
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
        $query = Modulerp::find();

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
            'MODUL_ID' => $this->MODUL_ID,
            'MODUL_STS' => $this->MODUL_STS,
            'SORT' => $this->SORT,
        ]);

        $query->andFilterWhere(['like', 'MODUL_NM', $this->MODUL_NM])
            ->andFilterWhere(['like', 'MODUL_DCRP', $this->MODUL_DCRP]);

        return $dataProvider;
    }
}
