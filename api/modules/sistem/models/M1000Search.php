<?php
namespace crm\sistem\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use crm\sistem\models\M1000;
/**
 * M1000Search represents the model behind the search form about `lukisongroup\models\system\M1000`.
 */
class M1000Search extends M1000
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['kd_menu', 'nm_menu', 'jval', 'note', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'safe'],
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
        $query = M1000::find();
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
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'kd_menu', $this->kd_menu])
            ->andFilterWhere(['like', 'nm_menu', $this->nm_menu])
            ->andFilterWhere(['like', 'jval', $this->jval])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by]);
        return $dataProvider;
    }
}