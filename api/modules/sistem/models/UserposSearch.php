<?php

namespace crm\sistem\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use crm\sistem\models\Userpos;

/**
 * UserposSearch represents the model behind the search form about `crm\sistem\models\Userpos`.
 */
class UserposSearch extends Userpos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['POSITION_LOGIN'], 'integer'],
            [['POSITION_NM'], 'safe'],
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
        $query = Userpos::find();

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
            'POSITION_LOGIN' => $this->POSITION_LOGIN,
        ]);

        $query->andFilterWhere(['like', 'POSITION_NM', $this->POSITION_NM]);

        return $dataProvider;
    }
}
