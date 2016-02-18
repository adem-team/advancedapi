<?php

namespace api\modules\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\master\Barangumum;

/**
 * BarangumumSearch represents the model behind the search form about `app\models\master\Barangumum`.
 */
class BarangumumSearch extends Barangumum
{
	public $nmtype;
	public $nmktegori;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'STATUS'], 'integer'],
            [['KD_BARANG', 'NM_BARANG', 'KD_TYPE', 'KD_KATEGORI', 'KD_UNIT', 'KD_SUPPLIER', 'KD_DISTRIBUTOR', 'PARENT', 'BARCODE', 'IMAGE', 'NOTE', 'KD_CORP', 'KD_CAB', 'KD_DEP', 'CREATED_BY', 'CREATED_AT', 'UPDATED_BY', 'UPDATED_AT', 'DATA_ALL'], 'safe'],
            [['HPP', 'HARGA'], 'number'],
            [['nmtype','nmktegori'], 'safe'],
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
        $query = Barangumum::find()->where('B1000.STATUS <> 3');
		$query->joinWith(['type' => function ($q) {
			$q->where('B1001.NM_TYPE LIKE "%' . $this->nmtype . '%"');
		}]);
		$query->joinWith(['kategori' => function ($q) {
			$q->where('B1002.NM_KATEGORI LIKE "%' . $this->nmktegori . '%"');
		}]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

		 $dataProvider->setSort([
			'attributes' => [
            'KD_BARANG',
            'NM_BARANG',
				'nmtype' => [
					'asc' => ['B1001.NM_TYPE' => SORT_ASC],
					'desc' => ['B1001.NM_TYPE' => SORT_DESC],
					'label' => 'Type',
				],
				'nmktegori' => [
					'asc' => ['B1002.NM_KATEGORI' => SORT_ASC],
					'desc' => ['B1002.NM_KATEGORI' => SORT_DESC],
					'label' => 'Type'
				]
			]
		]);
		
    if (!($this->load($params) && $this->validate())) {
        /**
         * The following line will allow eager loading with country data 
         * to enable sorting by country on initial loading of the grid.
         */ 
        $query->joinWith(['type']);
        $query->joinWith(['kategori']);
        return $dataProvider;
    }

/*
        $query->andFilterWhere([
            'ID' => $this->ID,
            'HPP' => $this->HPP,
            'HARGA' => $this->HARGA,
            'STATUS' => $this->STATUS,
            'CREATED_AT' => $this->CREATED_AT,
            'UPDATED_AT' => $this->UPDATED_AT,
        ]);
        $query->andFilterWhere(['like', 'KD_BARANG', $this->KD_BARANG])
            ->andFilterWhere(['like', 'NM_BARANG', $this->NM_BARANG])
            ->andFilterWhere(['like', 'KD_TYPE', $this->KD_TYPE])
            ->andFilterWhere(['like', 'KD_KATEGORI', $this->KD_TYPE])
            ->andFilterWhere(['like', 'KD_UNIT', $this->KD_UNIT])
            ->andFilterWhere(['like', 'KD_SUPPLIER', $this->KD_SUPPLIER])
            ->andFilterWhere(['like', 'KD_DISTRIBUTOR', $this->KD_DISTRIBUTOR])
            ->andFilterWhere(['like', 'BARCODE', $this->BARCODE])
            ->andFilterWhere(['like', 'IMAGE', $this->IMAGE])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE])
            ->andFilterWhere(['like', 'KD_CORP', $this->KD_CORP])
            ->andFilterWhere(['like', 'KD_CAB', $this->KD_CAB])
            ->andFilterWhere(['like', 'KD_DEP', $this->KD_DEP])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
            ->andFilterWhere(['like', 'UPDATED_BY', $this->UPDATED_BY])
            ->andFilterWhere(['like', 'DATA_ALL', $this->DATA_ALL]);
*/
        return $dataProvider;
    }
}
