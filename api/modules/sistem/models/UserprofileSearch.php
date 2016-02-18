<?php

namespace api\modules\sistem\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\sistem\models\Userprofile;

/**
 * UserprofileSearch represents the model behind the search form about `crm\sistem\models\Userprofile`.
 */
class UserprofileSearch extends Userprofile
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'STS', 'KD_OUTSRC', 'STATUS'], 'integer'],
            [['NM_FIRST', 'NM_MIDDLE', 'NM_END', 'JOIN_DATE', 'RESIGN_DATE', 'EMP_IMG', 'KD_DISTRIBUTOR', 'KD_SUBDIST', 'KTP', 'ALAMAT', 'ZIP', 'GENDER', 'TGL_LAHIR', 'EMAIL', 'TLP_HOME', 'HP', 'CORP_ID', 'CREATED_BY', 'CREATED_AT', 'UPDATED_BY', 'UPDATED_TIME'], 'safe'],
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
        $query = Userprofile::find();

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
            'JOIN_DATE' => $this->JOIN_DATE,
            'RESIGN_DATE' => $this->RESIGN_DATE,
            'STS' => $this->STS,
            'KD_OUTSRC' => $this->KD_OUTSRC,
            'TGL_LAHIR' => $this->TGL_LAHIR,
            'CREATED_AT' => $this->CREATED_AT,
            'UPDATED_TIME' => $this->UPDATED_TIME,
            'STATUS' => $this->STATUS,
        ]);

        $query->andFilterWhere(['like', 'NM_FIRST', $this->NM_FIRST])
            ->andFilterWhere(['like', 'NM_MIDDLE', $this->NM_MIDDLE])
            ->andFilterWhere(['like', 'NM_END', $this->NM_END])
            ->andFilterWhere(['like', 'EMP_IMG', $this->EMP_IMG])
            ->andFilterWhere(['like', 'KD_DISTRIBUTOR', $this->KD_DISTRIBUTOR])
            ->andFilterWhere(['like', 'KD_SUBDIST', $this->KD_SUBDIST])
            ->andFilterWhere(['like', 'KTP', $this->KTP])
            ->andFilterWhere(['like', 'ALAMAT', $this->ALAMAT])
            ->andFilterWhere(['like', 'ZIP', $this->ZIP])
            ->andFilterWhere(['like', 'GENDER', $this->GENDER])
            ->andFilterWhere(['like', 'EMAIL', $this->EMAIL])
            ->andFilterWhere(['like', 'TLP_HOME', $this->TLP_HOME])
            ->andFilterWhere(['like', 'HP', $this->HP])
            ->andFilterWhere(['like', 'CORP_ID', $this->CORP_ID])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
            ->andFilterWhere(['like', 'UPDATED_BY', $this->UPDATED_BY]);

        return $dataProvider;
    }
}
