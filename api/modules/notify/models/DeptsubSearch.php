<?php

namespace lukisongroup\models\hrd;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\models\hrd\Deptsub;

/**
 * DeptsubSearch represents the model behind the search form about `lukisongroup\models\hrd\Deptsub`.
 */
class DeptsubSearch extends Deptsub
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DEP_SUB_ID', 'DEP_ID', 'DEP_SUB_NM', 'DEP_SUB_AVATAR', 'DEP_SUB_DCRP'], 'safe'],
            [['DEP_SUB_STS', 'SORT'], 'integer'],
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
        $query = Deptsub::find();

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
            'DEP_SUB_STS' => $this->DEP_SUB_STS,
            'SORT' => $this->SORT,
        ]);

        $query->andFilterWhere(['like', 'DEP_SUB_ID', $this->DEP_SUB_ID])
            ->andFilterWhere(['like', 'DEP_ID', $this->DEP_ID])
            ->andFilterWhere(['like', 'DEP_SUB_NM', $this->DEP_SUB_NM])
            ->andFilterWhere(['like', 'DEP_SUB_AVATAR', $this->DEP_SUB_AVATAR])
            ->andFilterWhere(['like', 'DEP_SUB_DCRP', $this->DEP_SUB_DCRP]);

        return $dataProvider;
    }
}
