<?php

namespace api\modules\efenbi\rasasayang\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\efenbi\rasasayang\models\Store;

/**
 * StoreSearch represents the model behind the search form about `api\modules\efenbi\rasasayang\models\Store`.
 */
class StoreSearch extends Store
{
	public function attributes()
	{
		//Author -ptr.nov- add related fields to searchable attributes 
		return array_merge(parent::attributes(), ['LocatesubNm','LocateNm']);
	}
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'STATUS','LOCATE_SUB', 'LOCATE'], 'integer'],
            [['CREATE_BY', 'CREATE_AT', 'UPDATE_BY', 'UPDATE_AT','OUTLET_BARCODE', 'OUTLET_NM', 'ALAMAT', 'PIC', 'TLP','LocatesubNm','LocateNm'], 'safe'],
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
        $query = Store::find()->JoinWith('locateTbl',true,'LEFT JOIN')->JoinWith('locatesubTbl',true,'LEFT JOIN');

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
            'store.ID' => $this->ID,
            'store.STATUS' => $this->STATUS,
            'store.LOCATE' => $this->LOCATE,
        ]);
		/* SORTING Group Function Author -ptr.nov-*/
		$dataProvider->sort->attributes['LocateNm'] = [
			'asc' => ['locate.LOCATE_NAME' => SORT_ASC],
			'desc' => ['locate.LOCATE_NAME' => SORT_DESC],
		];
		$dataProvider->sort->attributes['LocatesubNm'] = [
			'asc' => ['locate.LOCATE_NAME' => SORT_ASC],
			'desc' => ['locate.LOCATE_NAME' => SORT_DESC],
		];
		
        $query->andFilterWhere(['like', 'store.CREATE_BY', $this->CREATE_BY])           
            ->andFilterWhere(['like', 'store.CREATE_AT', $this->CREATE_AT])
			 ->andFilterWhere(['like', 'store.UPDATE_BY', $this->UPDATE_BY])
            ->andFilterWhere(['like', 'store.UPDATE_AT', $this->UPDATE_AT])
            ->andFilterWhere(['like', 'store.LOCATE_SUB', $this->LOCATE_SUB])
            ->andFilterWhere(['like', 'store.OUTLET_BARCODE', $this->OUTLET_BARCODE])
            ->andFilterWhere(['like', 'store.OUTLET_NM', $this->OUTLET_NM])
            ->andFilterWhere(['like', 'store.ALAMAT', $this->ALAMAT])
            ->andFilterWhere(['like', 'store.PIC', $this->PIC])
            ->andFilterWhere(['like', 'store.TLP', $this->TLP])
            ->andFilterWhere(['like', 'locate.LOCATE_NAME', $this->getAttribute('LocateNm')])
            ->andFilterWhere(['like', 'locatesub.LOCATE_NAME', $this->getAttribute('LocatesubNm')]);

        return $dataProvider;
    }
}
